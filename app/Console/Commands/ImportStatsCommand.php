<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\CampaignStat;
use App\Models\UtmTerm;
use Illuminate\Console\Command;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\NullableType;

class ImportStatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-stats {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import stats from CSV files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->argument('filename');

        $filename = 'storage/'.$filename;

        //check file exist or not
        if(!file_exists($filename)) {
            $this->error("Keep the file inside storage folder ");
            //$this->error('File not found');
            exit;
        }

        $file = fopen($filename, 'r'); // open in reading mode , we  have various mode like read ,write , read-write
        $this->info('Importing stats from CSV file');
        $rowCount = 0;
        DB::beginTransaction();// added for data consistency,if error happen in the middle then everything will rollback to original state
        while (($row = fgetcsv($file)) !== false) {
            if($rowCount == 0) {
                $rowCount++;
                continue;
            }
            $rowCount++;
            $utmCampaign = strtolower($row[0]) != 'null' && !empty(trim($row[0])) ? trim($row[0]) : null;  // checking row value
            $utmTerm     = strtolower($row[1]) != 'null' && !empty(trim($row[1])) ? trim($row[1]) : null;  // checking row value
            $utmTime     = $row[2];
            $utmRevenue  = (float)$row[3];



            if ($utmCampaign && $utmTerm) {

                $campaignId = $utmCampaign ? Campaign::firstOrCreate(['utm_campaign' => $utmCampaign], ['utm_campaign' => $utmCampaign, 'name' => $utmCampaign]) : null;
                $utmTermId = $utmTerm ? UtmTerm::firstOrCreate(['utm_term' => $utmTerm]) : null; // first it will check existence of data if not found then it will create

               try {
                    $newStat = new CampaignStat();
                    $newStat->campaign_id = $campaignId?$campaignId->id:null;
                    $newStat->utm_term_id = $utmTermId?$utmTermId->id:null;
                    $newStat->monetization_timestamp = $utmTime;
                    $newStat->revenue = $utmRevenue;
                    $newStat->save();

                    $this->info(@$campaignId->id. '    ' . @$utmTermId->id . '    ' . $rowCount) . PHP_EOL;  //@ sign will dispose any error in printing so that loop remains intact

                } catch (\Exception $exception) {
                    DB::rollBack(); //roll back to orginal db state
                    $this->error("Error on $rowCount  " . $exception->getMessage());
                    $this->info("Please import stats from CSV file as previous data rollback");
                    break;
                }
            }else{
                $this->error('Missing utmCampign or utmTerm at row ' . $rowCount);
            }

        }

        DB::commit();
        $this->info('Importing stats from CSV file completed');

    }
}
