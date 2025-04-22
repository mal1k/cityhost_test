<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UpdateWhoisServers extends Command
{
    private const TLDS_ALPHA_URL  = 'https://data.iana.org/TLD/tlds-alpha-by-domain.txt';
    private const WHOIS_URL = 'https://www.iana.org/whois?q=.';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whois:update-servers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch TLD servers from IANA and save to storage/app/tldservers.json';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->components->info('Downloading TLD servers list...');

        try {
            $rows = Http::withoutVerifying()->get(self::TLDS_ALPHA_URL)->throw()->body();
            $alphaNames = array_filter(explode("\n", $rows), fn ($line) => $line && $line[0] !== '#');

            $progressBar = $this->output->createProgressBar(count($alphaNames));

            $map = [];
            foreach ($alphaNames as $alphaName) {
                $whoisTxt = Http::withoutVerifying()->get(self::WHOIS_URL . strtolower($alphaName))->body();

                if (preg_match('/^whois:\s+(\S+)$/mi', $whoisTxt, $match))
                    $map[strtolower($alphaName)] = trim($match[1]);

                $progressBar->advance();
            }
            
            $progressBar->finish();
            $this->newLine(2);

            Storage::disk('local')->put('tldservers.json', json_encode($map, JSON_PRETTY_PRINT));

            $this->components->success('Saved '.count($map).' servers to storage/app/private/tldservers.json');
            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->components->error('Error updating TLD servers: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}