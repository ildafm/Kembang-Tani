<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use Kreait\Firebase\Database;

class ZoneTwoController extends Controller
{

    private $database, $tableNameZone2;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tableNameZone2 = 'soil_zone_2';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "Monitoring Zone 2";
        $active = "zone_2";

        $datas = $this->database->getReference($this->tableNameZone2)->getValue();

        if (!empty($datas)) {
            $lastRecord = end($datas);

            usort($datas, function ($a, $b) {
                return $b['timestamp']['epoch'] - $a['timestamp']['epoch'];
            });

            // $lastRecord now contains the last record from the associative array
            return view("monitoring.zone_two")
                ->with('datas', $datas)
                ->with('active', $active)
                ->with('lastRecord', $lastRecord)
                ->with('title', $title);
        } else {
            // Handle the case when there is no data
            return view("monitoring.zone_two")
                ->with('active', $active)
                ->with('title', $title)
                ->with('datas', '0')
                ->with('lastRecord', '0');
        }
    }

    public function getRealtimeDataLastData()
    {
        $datas = $this->database->getReference($this->tableNameZone2)->getValue();

        if (!empty($datas)) {
            $lastRecord = end($datas);
            return response()->json($lastRecord);
        } else {
            response()->json("failed!!");
        }
    }

    public function getRealTimeData()
    {
        $datas = $this->database->getReference($this->tableNameZone2)->getValue();

        if (!empty($datas)) {

            usort($datas, function ($a, $b) {
                return $a['timestamp']['epoch'] - $b['timestamp']['epoch'];
            });

            return response()->json($datas);
        } else {
            response()->json("failed!!");
        }
    }
}
