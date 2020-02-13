<?php

namespace CynoBit\Splint\Commands;

use CynoBit\PHPCLI\Printer;

class Install
{
    use Printer;

    public function run(?array $packages): void
    {
        if ($packages) {
            $packages = $this->validate_package_names($packages);

            $this->println("The Following Pacakages will be Installed...");

            foreach ($packages as $package) {
                $this->println("[*] $package");
            }
        }
    }

    private function validate_package_names(array $packages): array
    {
        return [];
    }
}
