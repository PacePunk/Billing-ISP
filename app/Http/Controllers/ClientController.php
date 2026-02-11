<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Invoice;

class ClientController extends Controller
{
    public function index()
    {
        return view('client.login');
    }

    public function check(Request $request)
    {
        // Validasi input
        $request->validate([
            'phone_number' => 'required',
        ]);

        $customer = Customer::where('phone_number', $request->phone_number)->first();

        if (!$customer) {
            return back()->with('error', 'Nomor HP tidak ditemukan dalam sistem.');
        }

        $subscription = Subscription::where('customer_id', $customer->id)->first();

        if (!$subscription) {
            return back()->with('error', 'Anda terdaftar tapi belum mengambil paket internet.');
        }

        return redirect()->route('client.dashboard', $customer->id);
    }

    public function dashboard($customerId)
    {
        $subscription = Subscription::with(['customer', 'package', 'invoices'])
            ->where('customer_id', $customerId)
            ->firstOrFail();

        $unpaidInvoices = $subscription->invoices->where('status', 'unpaid');

        return view('client.dashboard', compact('subscription', 'unpaidInvoices'));
    }

    public function halamanBayar($id)
    {
    
    $invoice = Invoice::findOrFail($id);

    
    return view('client.bayar', compact('invoice'));
    }
}