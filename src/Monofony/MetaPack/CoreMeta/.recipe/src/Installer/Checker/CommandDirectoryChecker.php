<?php

declare(strict_types=1);

namespace App\Installer\Checker;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Iterator\RecursiveDirectoryIterator;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class CommandDirectoryChecker
{
    private ?string $name = null;

    public function __construct(private Filesystem $filesystem)
    {
    }

    public function ensureDirectoryExists(string $directory, OutputInterface $output): void
    {
        if (!is_dir($directory)) {
            $this->createDirectory($directory, $output);
        }
    }

    public function ensureDirectoryIsWritable(string $directory, OutputInterface $output): void
    {
        try {
            $this->changePermissionsRecursively($directory, $output);
        } catch (AccessDeniedException $exception) {
            $output->writeln($this->createBadPermissionsMessage($exception->getMessage()));

            throw new \RuntimeException('Failed while trying to change directory permissions.');
        }
    }

    public function setCommandName(string $name): void
    {
        $this->name = $name;
    }

    private function createDirectory(string $directory, OutputInterface $output): void
    {
        try {
            $this->filesystem->mkdir($directory, 0755);
        } catch (IOException $exception) {
            $output->writeln($this->createUnexistingDirectoryMessage(getcwd().'/'.$directory));

            throw new \RuntimeException('Failed while trying to create directory.');
        }

        $output->writeln(sprintf('<comment>Created "%s" directory.</comment>', $directory));
    }

    private function changePermissionsRecursively(string $directory, OutputInterface $output): void
    {
        if (is_file($directory) && is_writable($directory)) {
            return;
        }

        if (!is_writable($directory)) {
            $this->changePermissions($directory, $output);

            return;
        }

        foreach (new RecursiveDirectoryIterator($directory, \FilesystemIterator::CURRENT_AS_FILEINFO) as $subdirectory) {
            if ('.' !== $subdirectory->getFilename()[0]) {
                $this->changePermissionsRecursively($subdirectory->getPathname(), $output);
            }
        }
    }

    /**
     * @throws AccessDeniedException if directory/file permissions cannot be changed
     */
    private function changePermissions(string $directory, OutputInterface $output): void
    {
        try {
            $this->filesystem->chmod($directory, 0755, 0000, true);

            $output->writeln(sprintf('<comment>Changed "%s" permissions to 0755.</comment>', $directory));
        } catch (IOException $exception) {
            throw new AccessDeniedException(dirname($directory));
        }
    }

    private function createUnexistingDirectoryMessage(string $directory): string
    {
        return
            '<error>Cannot run command due to unexisting directory (tried to create it automatically, failed).</error>'.PHP_EOL.
            sprintf('Create directory "%s" and run command "<comment>%s</comment>"', $directory, $this->name)
        ;
    }

    private function createBadPermissionsMessage(string $directory): string
    {
        return
            '<error>Cannot run command due to bad directory permissions (tried to change permissions to 0755).</error>'.PHP_EOL.
            sprintf('Set "%s" writable recursively and run command "<comment>%s</comment>"', $directory, $this->name)
        ;
    }
}
