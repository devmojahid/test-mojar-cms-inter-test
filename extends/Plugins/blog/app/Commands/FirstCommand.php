<?php
namespace Plugin\Blog\Commands;

// src/Commands/YourCommand.php


use Illuminate\Console\Command;

class YourCommand extends Command
{
protected $signature = 'first:command';

protected $description = 'Description of your command.';

public function handle()
{
$this->info('This is your command!');
}
}