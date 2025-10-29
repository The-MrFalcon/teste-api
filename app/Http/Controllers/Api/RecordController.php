<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreRecordRequest;
use App\Http\Requests\UpdateRecordRequest;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Record;
class RecordController extends Controller
{
    public function index(Request $request, $patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $withTrashed = $request->query('with_trashed', false);
        $onlyTrashed = $request->query('only_trashed', false);

        $query = $patient->records();
        
        if ($withTrashed) {
            $query->withTrashed();
        } elseif ($onlyTrashed) {
            $query->onlyTrashed();
        }

        return response()->json($query->get());
    }
    public function store(StoreRecordRequest $request, $patientId)
    {
        $patient = Patient::findOrFail($patientId);
        Log::info($patient);
        $data = $request->validated();
        $data['patient_id'] = $patient->id;
        $record = Record::create($data);
        return response()->json($record, 201);
    }
    public function show($patientId, $recordId)
    {
        $record = Record::where('patient_id', $patientId)->findOrFail($recordId);
        return response()->json($record);
    }
    public function update(UpdateRecordRequest $request, $patientId, $recordId)
    {
        $record = Record::where('patient_id', $patientId)->findOrFail($recordId);
        $record->update($request->validated());
        return response()->json($record);
    }
    public function destroy($patientId, $recordId)
    {
        $record = Record::where('patient_id', $patientId)->findOrFail($recordId);
        $record->delete();
        return response()->json(null, 204);
    }

    public function restore($patientId, $recordId)
    {
        $record = Record::withTrashed()
            ->where('patient_id', $patientId)
            ->findOrFail($recordId);
        $record->restore();
        return response()->json($record);
    }

    public function forceDelete($patientId, $recordId)
    {
        $record = Record::withTrashed()
            ->where('patient_id', $patientId)
            ->findOrFail($recordId);
        $record->forceDelete();
        return response()->json(null, 204);
    }
}
