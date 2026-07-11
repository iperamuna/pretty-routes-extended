<?php

namespace Iperamuna\PrettyRoutesExtended\Console;

use Illuminate\Console\Command;

use function Laravel\Prompts\intro;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;
use function Termwind\render;

class TuiDemoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pretty-routes:tui-demo';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Demonstrate Termwind and Laravel Prompts integration';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        intro('Termwind + Laravel Prompts Demo');

        render(<<<'HTML'
            <div class="px-1 bg-blue-600 text-white font-bold">
                TRANSFORMING YOUR CLI EXPERIENCE
            </div>
            <div class="mt-1 italic text-gray-500">
                Using Termwind to style the output between prompts.
            </div>
        HTML);

        $name = text(
            label: 'What is your name?',
            placeholder: 'E.g. Indunil',
            required: true
        );

        $color = select(
            label: 'Choose a primary brand color',
            options: [
                'blue' => 'Blue',
                'green' => 'Green',
                'red' => 'Red',
                'purple' => 'Purple',
            ],
            default: 'blue'
        );

        render(<<<HTML
            <div class="mt-1">
                <span class="px-1 bg-{$color}-600 text-white uppercase">Result</span>
                <span class="ml-1 text-gray-300">Hello, <b>{$name}</b>! Your chosen brand color is <b>{$color}</b>.</span>
            </div>
            <div class="mt-1 p-1 border-dotted border-{$color}-500 text-{$color}-200">
                This box is dynamically styled using Termwind based on your input!
            </div>
        HTML);

        outro('Hope you enjoyed the demo!');
    }
}
