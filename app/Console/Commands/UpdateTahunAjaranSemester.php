<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateTahunAjaranSemester extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:tahunajaran-semester';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Tahun Ajaran Dan Semester';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentYear = date('Y');
        $currentMonth = date('m');

        if ($currentMonth >= 7) {
            $newTahunAjaran = $currentYear . '/' . ($currentYear + 1);
        } else {
            $newTahunAjaran = ($currentYear - 1) . '/' . $currentYear;
        }

        $newSemester = ($currentMonth >= 1 && $currentMonth <= 6) ? 'GENAP' : 'GANJIL';

        DB::table('profile_sekolah')->update([
            'tahunAjaran' => $newTahunAjaran,
            'semester' => $newSemester,
        ]);

        $this->info('Tahun ajaran and semester have been updated.');
    }
}
