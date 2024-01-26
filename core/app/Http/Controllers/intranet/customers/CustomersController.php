<?php

namespace App\Http\Controllers\intranet\customers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerPhone;
use App\Rules\CheckId;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
    public function __construct()
    {
    }

    public function get() {
        $query = Customer::select('customers.id', 'customers.alias', 'customers.name', 'customers.surname', 'customers.email');

        // Search

        $items = $query->get();

        return view('intranet/customers/customers-grid', ['items' => $items]);
    }

    public function getById($id) {
        $item = Customer::where('id', $id)->with('phones', 'creator', 'updater')->first();

        if ($item == null)
            abort(404);

        return view('intranet/customers/customer-form', ['item' => $item]);
    }

    public function create() {
        $item = new Customer();

        // Set defaults values
        $item->id = 0;
        $item->creator = Auth::user();
        $item->updater = Auth::user();
        $item->created_at = Carbon::now();
        $item->updated_at = Carbon::now();

        return view('intranet/customers/customer-form', ['item' => $item]);
    }

    public function set(Request $request)
    {
        $validateData = $request->validate([
            'id' =>'required|integer',
            'secureId' => [new CheckId($request->input('id'))],
            'name' => 'required',
            'email' => 'nullable|email',
            'birthdate' => 'nullable|date_format:"d/m/Y"',
            'web' => 'nullable|url'
        ]);

        // Get item to update
        $item = new Customer();
        if ($request->input('id') != 0)
            $item = Customer::find($request->input('id'));

        if ($item == null)
            abort(404);

        // Update item info
        $item->is_company = boolval($request->input('is_company'));
        $item->alias = $request->input('alias');
        $item->name = $request->input('name');
        $item->surname = $request->input('surname');
        $item->dni = $request->input('dni');
        $item->email = $request->input('email');
        $item->web = $request->input('web');
        $item->country = $request->input('country');
        $item->province = $request->input('province');
        $item->town = $request->input('town');
        $item->address = $request->input('address');
        $item->postal_code = $request->input('postal_code');
        $item->bank_account_number = $request->input('bank_account_number');
        $item->birthdate = Carbon::createFromFormat('d/m/Y', $request->input('birthdate'));
        $item->updated_by = Auth::user()->id;

        if (!$item->exists)
        {
            $item->created_by = Auth::user()->id;
        }

        $item->save();
        $item->tags()->sync($request->input('tags'));

        return redirect()
            ->action([CustomersController::class, 'getById'], ['id' => $item->id])
            ->with('message.success', 'Se ha guardado correctamente la información');
    }

    public function delete($id) {
        $item = Customer::find($id);
        if ($item == null)
        {
            return redirect()
                ->action([CustomersController::class, 'get'])
                ->with('message.error', 'No se ha podido eliminar el elemento indicado');
        }

        $item->delete();

        return redirect()->action([CustomersController::class, 'get'])->with('message.success', 'Se ha eliminado la información correctamente');
    }

    public function addPhone(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric'
        ]);

        $item = Customer::find($id);
        if ($item == null)
            return response()->json(null, 404);

        $phone = new CustomerPhone();
        $phone->prefix = $request->input('prefix', '+34');
        $phone->phone = $request->input('phone');
        $phone->description = $request->input('description');
        $phone->created_by = Auth::user()->id;
        $phone->updated_by = Auth::user()->id;

        $newPhone = $item->phones()->save($phone);
        return response()->json($newPhone->toArray());
    }

    public function deletePhone($customer_id, $id) {
        $item = CustomerPhone::find($id);
        if ($item == null || $item->customer_id != $customer_id)
            return response()->json(null, 404);

        $item->delete();
        return response()->json(null);
    }
}
