<?php
 
namespace App\Imports;
 
use App\Models\AcquirerFeed;
use App\Models\CosmosFeed;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
 
class CosmosImport implements ToModel, WithHeadingRow, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
 
        return CosmosFeed::create(array_intersect_key($row, array_flip((new CosmosFeed)->getFillable())));
 
    }
 
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2; // Assuming your data starts from the second row
    }
}
 