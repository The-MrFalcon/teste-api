<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
class PatientController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        $withTrashed = $request->query('with_trashed', false);
        $onlyTrashed = $request->query('only_trashed', false);

        $query = Patient::query();
        
        if ($withTrashed) {
            $query->withTrashed();
        } elseif ($onlyTrashed) {
            $query->onlyTrashed();
        }

        $patients = $query->paginate($perPage);
        return response()->json($patients);
    }

    public function store(StorePatientRequest $request)
    {
        $patient = Patient::create($request->validated());
        return response()->json($patient, 201);
    }
    public function show(Request $request, $id)
    {
        $withTrashed = $request->query('with_trashed', false);
        
        $query = Patient::with(['records' => function ($query) use ($withTrashed) {
            if ($withTrashed) {
                $query->withTrashed();
            }
        }]);

        if ($withTrashed) {
            $query->withTrashed();
        }

        $patient = $query->findOrFail($id);
        return response()->json($patient);
    }
    public function update(UpdatePatientRequest $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($request->validated());
        return response()->json($patient);
    }
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $patient = Patient::withTrashed()->findOrFail($id);
        $patient->restore();
        return response()->json($patient);
    }

    public function forceDelete($id)
    {
        $patient = Patient::withTrashed()->findOrFail($id);
        $patient->forceDelete();
        return response()->json(null, 204);
    }
}
