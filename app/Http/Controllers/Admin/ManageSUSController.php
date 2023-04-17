<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\sus;
use App\Models\sus_student;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use RealRashid\SweetAlert\Facades\Alert;

class ManageSUSController extends Controller
{
    public function index(){
        $last = sus::all()->last();
        $sus = sus::findOrfail($last->id);
        return view('pages.admin.manage_sus.index', compact('sus'));
    }

    public function sus(){
        $students =  sus_student::paginate(10);
        $sumAmount = sus_student::sum('amount');
        $countAnswer = sus_student::count();
        dd($sumAmount);
        if($sumAmount != 0 && $countAnswer != 0){
            $total = $sumAmount / $countAnswer;
        }else{
            $total = 0;
        }


        $description = '';
        if($total >= 80.3 ){
            $description = 'A';
        }else if($total >= 74 &&  $total < 80.3   ){
            $description = 'B';
        }else if($total >= 68 &&  $total < 74   ){
            $description = 'c';
        }else if($total >= 51  &&  $total < 68   ){
            $description = 'D';
        }else{
            $description = 'E';
        }


        $Q1CountAnswerOne = sus_student::where('Q1', 1)->count();
        $Q1CountAnswerTwo = sus_student::where('Q1', 2)->count();
        $Q1CountAnswerThree = sus_student::where('Q1', 3)->count();
        $Q1CountAnswerFour = sus_student::where('Q1', 4)->count();
        $Q1CountAnswerFive = sus_student::where('Q1', 5)->count();

        $Q2CountAnswerOne = sus_student::where('Q2', 1)->count();
        $Q2CountAnswerTwo = sus_student::where('Q2', 2)->count();
        $Q2CountAnswerThree = sus_student::where('Q2', 3)->count();
        $Q2CountAnswerFour = sus_student::where('Q2', 4)->count();
        $Q2CountAnswerFive = sus_student::where('Q2', 5)->count();

        $Q3CountAnswerOne = sus_student::where('Q3', 1)->count();
        $Q3CountAnswerTwo = sus_student::where('Q3', 2)->count();
        $Q3CountAnswerThree = sus_student::where('Q3', 3)->count();
        $Q3CountAnswerFour = sus_student::where('Q3', 4)->count();
        $Q3CountAnswerFive = sus_student::where('Q3', 5)->count();

        $Q4CountAnswerOne = sus_student::where('Q4', 1)->count();
        $Q4CountAnswerTwo = sus_student::where('Q4', 2)->count();
        $Q4CountAnswerThree = sus_student::where('Q4', 3)->count();
        $Q4CountAnswerFour = sus_student::where('Q4', 4)->count();
        $Q4CountAnswerFive = sus_student::where('Q4', 5)->count();

        $Q5CountAnswerOne = sus_student::where('Q5', 1)->count();
        $Q5CountAnswerTwo = sus_student::where('Q5', 2)->count();
        $Q5CountAnswerThree = sus_student::where('Q5', 3)->count();
        $Q5CountAnswerFour = sus_student::where('Q5', 4)->count();
        $Q5CountAnswerFive = sus_student::where('Q5', 5)->count();

        $Q6CountAnswerOne = sus_student::where('Q6', 1)->count();
        $Q6CountAnswerTwo = sus_student::where('Q6', 2)->count();
        $Q6CountAnswerThree = sus_student::where('Q6', 3)->count();
        $Q6CountAnswerFour = sus_student::where('Q6', 4)->count();
        $Q6CountAnswerFive = sus_student::where('Q6', 5)->count();

        $Q7CountAnswerOne = sus_student::where('Q7', 1)->count();
        $Q7CountAnswerTwo = sus_student::where('Q7', 2)->count();
        $Q7CountAnswerThree = sus_student::where('Q7', 3)->count();
        $Q7CountAnswerFour = sus_student::where('Q7', 4)->count();
        $Q7CountAnswerFive = sus_student::where('Q7', 5)->count();

        $Q8CountAnswerOne = sus_student::where('Q8', 1)->count();
        $Q8CountAnswerTwo = sus_student::where('Q8', 2)->count();
        $Q8CountAnswerThree = sus_student::where('Q8', 3)->count();
        $Q8CountAnswerFour = sus_student::where('Q8', 4)->count();
        $Q8CountAnswerFive = sus_student::where('Q8', 5)->count();

        $Q9CountAnswerOne = sus_student::where('Q9', 1)->count();
        $Q9CountAnswerTwo = sus_student::where('Q9', 2)->count();
        $Q9CountAnswerThree = sus_student::where('Q9', 3)->count();
        $Q9CountAnswerFour = sus_student::where('Q9', 4)->count();
        $Q9CountAnswerFive = sus_student::where('Q9', 5)->count();

        $Q10CountAnswerOne = sus_student::where('Q10', 1)->count();
        $Q10CountAnswerTwo = sus_student::where('Q10', 2)->count();
        $Q10CountAnswerThree = sus_student::where('Q10', 3)->count();
        $Q10CountAnswerFour = sus_student::where('Q10', 4)->count();
        $Q10CountAnswerFive = sus_student::where('Q10', 5)->count();

        return view("pages.admin.manage_sus.sus",
        compact(

            'students',
            'description',
            'total',
            'Q1CountAnswerOne','Q1CountAnswerTwo','Q1CountAnswerThree','Q1CountAnswerFour','Q1CountAnswerFive',
            'Q2CountAnswerOne','Q2CountAnswerTwo','Q2CountAnswerThree','Q2CountAnswerFour','Q2CountAnswerFive',
            'Q3CountAnswerOne','Q3CountAnswerTwo','Q3CountAnswerThree','Q3CountAnswerFour','Q3CountAnswerFive',
            'Q4CountAnswerOne','Q4CountAnswerTwo','Q4CountAnswerThree','Q4CountAnswerFour','Q4CountAnswerFive',
            'Q5CountAnswerOne','Q5CountAnswerTwo','Q5CountAnswerThree','Q5CountAnswerFour','Q5CountAnswerFive',
            'Q6CountAnswerOne','Q6CountAnswerTwo','Q6CountAnswerThree','Q6CountAnswerFour','Q6CountAnswerFive',
            'Q7CountAnswerOne','Q7CountAnswerTwo','Q7CountAnswerThree','Q7CountAnswerFour','Q7CountAnswerFive',
            'Q8CountAnswerOne','Q8CountAnswerTwo','Q8CountAnswerThree','Q8CountAnswerFour','Q8CountAnswerFive',
            'Q9CountAnswerOne','Q9CountAnswerTwo','Q9CountAnswerThree','Q9CountAnswerFour','Q9CountAnswerFive',
            'Q10CountAnswerOne','Q10CountAnswerTwo','Q10CountAnswerThree','Q10CountAnswerFour','Q10CountAnswerFive',
            )
        );
    }

    public function update(Request $request){
        $request->validate([
            'Q1' => 'required',
            'Q2' => 'required',
            'Q3' => 'required',
            'Q4' => 'required',
            'Q5' => 'required',
            'Q6' => 'required',
            'Q7' => 'required',
            'Q8' => 'required',
            'Q9' => 'required',
            'Q10' => 'required',
        ]);

        $last = sus::all()->last();
        $sus = sus::findOrfail($last->id);

        $sus->update([
            'Q1' => $request->Q1,
            'Q2' => $request->Q2,
            'Q3' => $request->Q3,
            'Q4' => $request->Q4,
            'Q5' => $request->Q5,
            'Q6' => $request->Q6,
            'Q7' => $request->Q7,
            'Q8' => $request->Q8,
            'Q9' => $request->Q9,
            'Q10' => $request->Q10,
        ]);

        Alert::success('Success', 'Data Berhasil Diedit');
        return back();
    }
}
