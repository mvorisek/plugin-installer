<?php

namespace Roundcube\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class RoundcubeInstaller implements PluginInterface
{
    private $extentions = [PluginInstaller::class, SkinInstaller::class];
    private $installers = [];

    public function activate(Composer $composer, IOInterface $io)
    {
        foreach ($this->extentions as $extension) {
            $installer = new $extension($io, $composer);
            $composer->getInstallationManager()->addInstaller($installer);
            $this->installers[] = $installer;
        }
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        foreach ($this->installers as $installer) {
            $composer->getInstallationManager()->removeInstaller($installer);
        }
    }

    public function uninstall(Composer $composer, IOInterface $io) {}
}
