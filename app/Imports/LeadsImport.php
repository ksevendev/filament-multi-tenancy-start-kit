<?php

namespace App\Imports;

use App\Models\Business\Lead;
use Filament\Facades\Filament;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class LeadsImport implements ToCollection
{
    public function collection(Collection $collection)
    {
        $insert = collect();

        if ($collection->count() > 0) {
            // append tenant_id to each row
            $collection->each(function ($row) use (&$insert) {
                $insert->put('tenant_id', Filament::getTenant()->id);
                $insert->put('name', $row[0]);
                $insert->put('document', $row[1]);
                $insert->put('email', $row[2]);
                $insert->put('phone', $row[3]);
                $insert->put('created_at', now());
                $insert->put('updated_at', now());
            });

            // insert all rows in the database
            Lead::insert($insert->toArray());

            return true;
        }
    }
}
