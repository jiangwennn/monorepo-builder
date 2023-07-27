<?php

declare(strict_types=1);

namespace Symplify\MonorepoBuilder\Release\Version;

use Nette\Utils\Strings;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Contract\Git\TagResolverInterface;
use Symplify\MonorepoBuilder\Release\Guard\ReleaseGuard;
use Symplify\MonorepoBuilder\Release\ValueObject\SemVersion;

final class VersionFactory
{
    public function __construct(
        private ReleaseGuard $releaseGuard,
        private TagResolverInterface $tagResolver
    ) {
    }

    public function createValidVersion(string $versionArgument, string $stage, ?string $nextVersionPrefix): Version
    {
        // normalize to workaround phar-io bug
        $versionArgument = strtolower($versionArgument);

        // remove 4th level
        if (in_array($versionArgument, SemVersion::ALL, true)) {
            return $this->resolveNextVersionByVersionKind($versionArgument, $nextVersionPrefix);
        }

        // this object performs validation of version
        $version = new Version($versionArgument);
        $this->releaseGuard->guardVersion($version, $stage);

        return $version;
    }

    private function resolveNextVersionByVersionKind(string $versionKind, ?string $versionPrefix): Version
    {
        // get current version
        $mostRecentVersionString = $this->tagResolver->resolve(getcwd());
        if ($mostRecentVersionString === null) {
            // the very first tag
            return new Version(sprintf("%s0.1.0", $versionPrefix));
        }

        // narrow long invalid version like 10.5.2.72 to 10.5.2
        $dotCount = substr_count($mostRecentVersionString, '.');
        if ($dotCount === 3) {
            $mostRecentVersionString = Strings::before($mostRecentVersionString, '.', -1);
        }

        $mostRecentVersion = new Version($mostRecentVersionString);

        $value = $mostRecentVersion->getMajor()
            ->getValue();
        $currentMinorVersion = $mostRecentVersion->getMinor()
            ->getValue();
        $currentPatchVersion = $mostRecentVersion->getPatch()
            ->getValue();

        if ($versionKind === SemVersion::MAJOR) {
            ++$value;
            $currentMinorVersion = 0;
            $currentPatchVersion = 0;
        }

        if ($versionKind === SemVersion::MINOR) {
            ++$currentMinorVersion;
            $currentPatchVersion = 0;
        }

        if ($versionKind === SemVersion::PATCH) {
            ++$currentPatchVersion;
        }

        return new Version(sprintf('%s%d.%d.%d', $versionPrefix, $value, $currentMinorVersion, $currentPatchVersion));
    }
}
