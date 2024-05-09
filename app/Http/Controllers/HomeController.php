<?php

namespace App\Http\Controllers;

use App\Models\Associate;
use App\Models\Award;
use App\Models\Enrollment;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $award_id;

    public function index()
    {
        try {
            $this->award_id = $this->get_award_active();

            $totals = $this->get_totals();
            $enrollments = $this->get_last_enrollments();

            if(empty(Auth::user()->associate_id)){
                return view('dashboard', compact('totals', 'enrollments'));
            }else{
                return view('dashboard-associate', compact('totals', 'enrollments'));
            }
        } catch (Exception $ex) {
        }
    }

    private function get_totals()
    {
        if(!empty(Auth::user()->associate_id)){
            return array(
                'products' => ($this->award_id) ? Product::where('award_id', $this->award_id)->where('associate_id', Auth::user()->associate_id)->count() : 0,
                'enrollments' => ($this->award_id) ? Enrollment::where('award_id', $this->award_id)->where('associate_id', Auth::user()->associate_id)->count() : 0,
                'price' => ($this->award_id) ? Enrollment::where('award_id', $this->award_id)->where('associate_id',Auth::user()->associate_id)->sum('total') : 0,
            );
        }

        return array(
            'associates' => Associate::count(),
            'products' => ($this->award_id) ? Product::where('award_id', $this->award_id)->count() : 0,
            'enrollments' => ($this->award_id) ? Enrollment::where('award_id', $this->award_id)->count() : 0,
            'price' => ($this->award_id) ? Enrollment::where('award_id', $this->award_id)->sum('total') : 0,
            'total_complete' => Associate::where('status', 'complete')->count(),
            'total_incomplete' => Associate::where('status', 'incomplete')->count(),
            'total_site' => Associate::where('origin', 'site')->count(),
            'total_award' => Associate::where('origin', 'award')->count(),
            'total_email' => Associate::where('email', '<>', '')->count(),
        );
    }

    private function get_last_enrollments()
    {
        if(!empty(Auth::user()->associate_id)){
            return Enrollment::with('associate:id,first_name,fantasy_name,type')->where('award_id', $this->award_id)->where('associate_id', Auth::user()->associate_id)->orderBy('created_at', 'DESC')->limit(10)->get();
        }
        return Enrollment::with('associate:id,first_name,fantasy_name,type')->where('award_id', $this->award_id)->where('status', '<>', 'draft')->orderBy('created_at', 'DESC')->limit(10)->get();
    }

    private function get_award_active()
    {
        $award = Award::select('id')->where('status', 'enable')->first();
        if ($award) {
            return $award->id;
        }
        return null;
    }
}
