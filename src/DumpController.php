<?php

namespace Nembie\NovaDumpCard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DumpController extends Controller
{
    /**
     * Dump the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dump(Request $request)
    {
        if(env('DB_CONNECTION') != 'mysql' && env('DB_CONNECTION') != 'sqlite')
            return response()->json(['message' => 'This package only works with MySQL or SQLite databases'], 500);

        $request->validate([
            'sqlDumpPath' => 'string|nullable',
            'dumpPath' => 'string|nullable',
            'dumpName' => 'string|nullable',
            'database' => 'string|nullable',
            'onlyStructure' => 'boolean|nullable'
        ]);

        $dumpName = $request->dumpName ?? 'dump_'.date('Ymd').'_'.date('His');
        $cmd = env('DB_CONNECTION') == 'mysql' ? $this->dumpSql($request, $dumpName) : $this->dumpSqlite($request, $dumpName);

        try {
            exec($cmd);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }

        return response()->json([
            'message' => 'Dump created successfully',
        ], 200);
    }

    /*
    * Dump the database using mysqldump
    */
    protected function dumpSql($request, $dumpName)
    {
        $sqlDumpPath = $request->sqlDumpPath ?? 'mysqldump';
        
        if($request->onlyStructure)
            $sqlDumpPath .= ' --no-data';

        $dumpPath = $request->dumpPath.'/'.$dumpName.'.sql' ?? storage_path($dumpName.'.sql');
        $user = env('DB_USERNAME');
        $psw = env('DB_PASSWORD');
        $db = $request->database ?? env('DB_DATABASE');

        return "$sqlDumpPath -u $user -p$psw $db > $dumpPath";
    }

    /*
    * Dump the database using sqlite3
    */
    protected function dumpSqlite($request, $dumpName)
    {
        $sqlDumpPath = $request->sqlDumpPath ?? 'sqlite3';
        $onlyStructure = $request->onlyStructure ? '.schema' : '.dump';

        $dumpPath = $request->dumpPath.'/'.$dumpName.'.sql' ?? storage_path($dumpName.'.sql');
        $db = $request->database ?? env('DB_DATABASE');

        return "$sqlDumpPath $db $onlyStructure > $dumpPath";
    }
}