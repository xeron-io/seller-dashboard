<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Voucher;
use App\Models\Transactions;
use App\Http\Controllers\AuthController;
use App\Models\Product;

class VoucherController extends Controller
{
	public function index()
	{
		$store = Store::where('id_seller', AuthController::getJWT()->sub)->get();
		$voucher = Voucher::whereHas('store', function($q) {
			$q->where('id_seller', AuthController::getJWT()->sub);
		})->with('store')->get();

		return view('dashboard.voucher', [
			'title' => 'Voucher',
			'subtitle' => 'Lihat semua voucher yang toko anda miliki',
			'store' => $store,
			'voucher' => $voucher,
		]);
	}

	public function detail($id)
	{
		$voucher = Voucher::where('id', $id)->whereHas('store', function($q) {
			$q->where('id_seller', AuthController::getJWT()->sub);
		})->with('store')->first();

		return response()->json($voucher);
	}

	public function create(Request $request)
	{
		$type = ['percent', 'fixed'];

		// check coupon type
		if($request->type == 'percent') {
			$rules_nominal = 'required|numeric|min:1|max:100';
		} elseif($request->type == 'fixed') {
			$rules_nominal = 'required|numeric|min:1000';
		}

		$rules_expire = $request->not_expired == '1' ? '' : 'required|date|after:today';

		$request->validate([
			'id_store' => 'required|numeric|exists:stores,id',
			'code' => 'required|unique:voucher,code|string|min:5|max:20',
			'type' => 'required|in:'.implode(',', $type),
			'nominal' => $rules_nominal,
			'limit' => 'required|numeric',
			'expired_at' => $rules_expire,
		]);

		// insert to database
		Voucher::create([
			'id_store' => $request->id_store,
			'code' => $request->code,
			'type' => $request->type,
			'amount' => $request->nominal,
			'limit' => $request->limit,
			'expired_at' => $request->expired_at ? date('Y-m-d H:i:s', strtotime($request->expired_at)) : null,
		]);

		return redirect()->route('dash.voucher')->with('success', 'Voucher anda berhasil dibuat');
	}

	public function edit(Request $request, $id)
	{
		$type = ['percent', 'fixed'];

		// check coupon type
		if($request->type == 'percent') {
			$rules_nominal = 'required|numeric|min:1|max:100';
		} elseif($request->type == 'fixed') {
			$rules_nominal = 'required|numeric|min:1000';
		}

		$rules_expire = $request->not_expired == '1' ? '' : 'required|date|after:today';

		$request->validate([
			'id_store' => 'required|numeric|exists:stores,id',
			'code' => 'required|string|min:5|max:20|unique:voucher,code,'.$id,
			'type' => 'required|in:'.implode(',', $type),
			'nominal' => $rules_nominal,
			'limit' => 'required|numeric',
			'expired_at' => $rules_expire,
		]);

		// update to database
		Voucher::where('id', $id)->update([
			'id_store' => $request->id_store,
			'code' => $request->code,
			'type' => $request->type,
			'amount' => $request->nominal,
			'limit' => $request->limit,
			'expired_at' => $request->expired_at ? date('Y-m-d H:i:s', strtotime($request->expired_at)) : null,
		]);

		return redirect()->route('dash.voucher')->with('success', 'Voucher anda berhasil di update');
	}

	public function delete($id)
	{
		// delete from database
		Voucher::where('id', $id)->delete();

		return redirect()->route('dash.voucher')->with('success', 'Voucher anda berhasil di hapus');
	}
}
