<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Clock\Clock;

class StudentController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->only(['name', 'nim', 'ymd']);
        $response = Http::get('https://bit.ly/48ejMhW');
        $data = $response->body();
        $parseData = json_decode($data);
        $lines = explode("\n", trim($parseData->DATA));

        $students = [];

        foreach ($lines as $index => $line) {
            if (empty(trim($line))) continue;

            $parts = explode("|", $line);
            if (count($parts) !== 3) continue;

            //mapping field name
            if ($index === 0) {
                $fieldName= '';
                $fieldNIM = '';
                $fieldymd = '';
                foreach ($parts as $key => $value) {
                    // clock($value, $key);
                    if ($value == 'NAMA') {
                        $fieldName = $key;
                    } elseif ($value == 'NIM') {
                        $fieldNIM = $key;
                    } elseif ($value == 'YMD') {
                        $fieldymd = $key;
                    }

                }

            }

            clock($fieldName, $fieldNIM, $fieldymd);
            if ($index !== 0) {
                $student = [
                    'name' => trim($parts[$fieldName]),
                    'ymd' => trim($parts[$fieldymd]),
                    'nim' => trim($parts[$fieldNIM])
                ];
                $students[] = $student;
            }

        }

        $filtered = collect($students)->filter(function ($student) use ($query) {

            foreach ($query as $key => $value) {
                // if (strtolower($student[$key]) !== strtolower($value)) {
                //     return false;
                // }
                if (!str_contains(strtolower($student[$key]) ,strtolower($value))) {
                    return false;
                }

            }
            return true;
        });

        return $filtered->values()->all();
    }
}

