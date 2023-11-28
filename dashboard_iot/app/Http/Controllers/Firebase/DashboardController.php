<?php

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Database;

class DashboardController extends Controller
{
    private $database, $tableNameZone1, $tableNameZone2;

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tableNameZone1 = 'soil_zone_1';
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
        // $datas = $this->database->getReference($this->tableNameZone1)->getValue();
        $active = "dashboard";
        $title = "Dashboard";

        $datas_zone_1 = $this->database->getReference($this->tableNameZone1)->getValue();
        $datas_zone_2 = $this->database->getReference($this->tableNameZone2)->getValue();

        $lastRecordZone1 = end($datas_zone_1);
        $lastRecordZone2 = end($datas_zone_2);

        $percent_value_zone_1 = $lastRecordZone1['percent_value'];
        $percent_value_zone_2 = $lastRecordZone2['percent_value'];

        return view("dashboard.index2")
            // ->with('datas', $datas)
            ->with('active', $active)
            ->with('percent_value_zone_1', $percent_value_zone_1)
            ->with('percent_value_zone_2', $percent_value_zone_2)
            ->with('title', $title);
    }

    public function getRealtimeData()
    {
        $datas_zone_1 = $this->database->getReference($this->tableNameZone1)->getValue();
        $datas_zone_2 = $this->database->getReference($this->tableNameZone2)->getValue();

        if (!empty($datas_zone_1) && !empty($datas_zone_2)) {
            $lastRecordZone1 = end($datas_zone_1);
            $lastRecordZone2 = end($datas_zone_2);

            $arr_data_zone = [
                'lastRecordZone1' => $lastRecordZone1,
                'lastRecordZone2' => $lastRecordZone2,
            ];

            return response()->json($arr_data_zone);
        } else {
            response()->json("failed!!");
        }
    }
}
