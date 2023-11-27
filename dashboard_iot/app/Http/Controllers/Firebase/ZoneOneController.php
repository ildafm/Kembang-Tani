<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use Kreait\Firebase\Database;

class ZoneOneController extends Controller
{
    private $database, $tableNameZone1;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tableNameZone1 = 'soil_zone_1';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $title = "Monitoring Zone 1";
        $active = "zone_1";

        $datas = $this->database->getReference($this->tableNameZone1)->getValue();
        // $datas2 = '{"name": "John", "age": 30, "address": {"city": "New York", "zip": "10001"}}';
        // dd($datas);
        // dd($datas2);

        if (!empty($datas)) {
            $lastRecord = end($datas);

            usort($datas, function ($a, $b) {
                return $b['timestamp']['epoch'] - $a['timestamp']['epoch'];
            });

            // $lastRecord now contains the last record from the associative array
            return view("monitoring.zone_one")
                ->with('datas', $datas)
                ->with('active', $active)
                ->with('lastRecord', $lastRecord)
                ->with('title', $title);
        } else {
            // Handle the case when there is no data
            return view("monitoring.zone_one")
                ->with('datas', '0')
                ->with('lastRecord', '0')
                ->with('title', $title)
                ->with('active', $active);
        }
    }

    public function getRealtimeDataLastData()
    {
        $datas = $this->database->getReference($this->tableNameZone1)->getValue();

        if (!empty($datas)) {
            $lastRecord = end($datas);
            return response()->json($lastRecord);
        } else {
            response()->json("failed!!");
        }
    }

    public function getRealTimeData()
    {
        $datas = $this->database->getReference($this->tableNameZone1)->getValue();

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
