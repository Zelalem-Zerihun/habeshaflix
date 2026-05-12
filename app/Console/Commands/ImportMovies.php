<?php

namespace App\Console\Commands;

use App\Models\Cast;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-movies {file : The path to the CSV file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import movies from a CSV file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return 1;
        }

        $admin = User::where('role', 'admin')->first() ?: User::first();
        
        if (!$admin) {
            $this->error('No user found to assign as creator. Please seed users first.');
            return 1;
        }

        $file = fopen($filePath, 'r');
        $header = fgetcsv($file);

        // Map header to indices
        $headerMap = array_flip($header);

        $count = 0;
        
        DB::beginTransaction();
        try {
            while (($row = fgetcsv($file)) !== false) {
                $title = $row[$headerMap['title']] ?? 'Unknown';
                $year = $row[$headerMap['year']] ?? null;
                $youtubeId = $row[$headerMap['youtube_id']] ?? null;
                $castJson = $row[$headerMap['cast']] ?? '[]';

                if (!$youtubeId) {
                    $this->warn("Skipping row without youtube_id: {$title}");
                    continue;
                }

                $movie = Movie::updateOrCreate(
                    ['youtube_id' => $youtubeId],
                    [
                        'title' => $title,
                        'year' => (int)$year,
                        'description' => '', // Empty as requested
                        'status' => 'approved',
                        'created_by' => $admin->id,
                    ]
                );

                $casts = json_decode($castJson, true);
                if (is_array($casts)) {
                    $castIds = [];
                    foreach ($casts as $castData) {
                        $cast = Cast::firstOrCreate(
                            ['name' => $castData['name']],
                            ['image' => $castData['profile_image'] ?? null]
                        );
                        $castIds[] = $cast->id;
                    }
                    $movie->castMembers()->sync($castIds);
                }

                $count++;
                if ($count % 50 === 0) {
                    $this->info("Imported {$count} movies...");
                }
            }
            DB::commit();
            $this->info("Successfully imported {$count} movies!");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Error importing movies: " . $e->getMessage());
            return 1;
        }

        fclose($file);
        return 0;
    }
}
