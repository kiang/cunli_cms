<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CunliImportCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cunli:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'to import cunli data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
        $path = $this->argument('json');
        if (file_exists($path . '/list.json')) {
            $listInfo = json_decode(file_get_contents($path . '/list.json'), true);

            County::truncate();
            Town::truncate();
            Cunli::truncate();

            foreach ($listInfo['counties'] AS $id => $county) {
                $d = new County();
                $d->id = $id;
                $d->title = $county;
                $d->save();
            }

            foreach ($listInfo['towns'] AS $id => $town) {
                $d = new Town();
                $d->id = $id;
                $d->county_id = $listInfo['town2county'][$id];
                $d->title = $town;
                $d->save();
            }

            $skippedList = array();
            foreach ($listInfo['county2towns'] AS $countyId => $townIds) {
                foreach ($townIds AS $townId) {
                    $townJson = json_decode(file_get_contents($path . '/' . $countyId . '_' . $townId . '.json'), true);
                    foreach ($townJson['objects']['layer1']['geometries'] AS $cunli) {
                        if (empty($cunli['properties']['V_ID'])) {
                            if (empty($cunli['properties']['VILLAGE_ID'])) {
                                $skippedList[] = $cunli;
                                continue;
                            }
                            $cunli['properties']['V_ID'] = $townId . '-' . $cunli['properties']['VILLAGE_ID'];
                        }
                        if (empty(Cunli::find($cunli['properties']['V_ID'], array('id')))) {
                            $d = new Cunli();
                            $d->id = $cunli['properties']['V_ID'];
                            $d->county_id = $countyId;
                            $d->town_id = $townId;
                            $d->title = $cunli['properties']['VILLAGE'];
                            $d->count_candidates = 0;
                            $d->save();
                        }
                    }
                }
            }
            
            file_put_contents('skipped.json', json_encode($skippedList));
        } else {
            $this->error('list.json does not exist');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
        return array(
            array('json', InputArgument::REQUIRED, 'path to json folder'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return array(
                //array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
        );
    }

}
