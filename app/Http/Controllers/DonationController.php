<?php

namespace App\Http\Controllers;

use App\Models\BloodTest;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    public function donationTest(Request $request){
        $donation=Donation::findOrFail($request->donation_id);
        $tr=BloodTest::where('donation_id',$donation->id)->first();
        return view('printdonationtest',compact('tr','donation'));
    }
    public  function getDonations()
    {
        if (auth()->user() && auth()->user()->donor) {

            $donor_id = auth()->user()->donor->id;
            $donations = Donation::with('blood_type')->where('donor_id', $donor_id)->get();
            return view('prevdonation', compact('donations'));
        }
        else{
            return view('prevdonation');
        }

    }
    public function index(){
        $topDonors = User::select('users.name', 'blood_types.blood_type', DB::raw('COUNT(donations.donor_id) as donation_count'))
            ->join('donors', 'users.id', '=', 'donors.user_id')
            ->join('blood_types', 'donors.blood_type_id', '=', 'blood_types.id')
            ->join('donations', 'donors.id', '=', 'donations.donor_id')
            ->groupBy('users.id', 'users.name', 'blood_types.blood_type')
            ->orderByDesc('donation_count')
            ->limit(10)
            ->get();
        return view('index',compact('topDonors'));
    }
    public function donate(){
        return view('donation');
    }
}
