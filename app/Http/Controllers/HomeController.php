<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\User;
//use App\Http\Controllers\Auth;
use App\Models\company_share_mappings;
use App\Models\company_share_data;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CompanyDataExport;





class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (\Illuminate\Support\Facades\Auth::check()) {
            // User is logged in
            return view('home');
        } else {
            // User is not logged in
            // Redirect to the login page or perform any other action
            return redirect()->route('guest');
        }
    }
    public function guest()
    {
        return view('homeguest');
    }


    public function userlist()
    {
        $users = User::where('user_type', '<>', 'a')->get();
        return view('users_list', compact('users'));
    }

    public function getStockYears(Request $request)
    {
        $company_id = $request->input('company_id');
        $stockYears = company_share_data::where('CompanyId', $company_id)->distinct()->pluck('StockYear')->toArray();
        
        return response()->json(['stockYears' => $stockYears]);

        
    }
    public function uploaddata()
    {
        # code...
        return view('uploaddata');
    }

    public function uploadDatafile(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'attachment' => 'required|mimes:xlsx,xls|max:2048' // Adjust max file size if needed
        ]);

        // Get the uploaded file
        $file = $request->file('attachment');

        // Read the Excel file data
        $data = Excel::toCollection(null, $file)[0]; // Assuming the data is in the first sheet

        // Remove the header row
        $data->shift();

        // Process each row of data
        foreach ($data as $row) {
            // Create a new CompanyShareData instance
            $shareData = new company_share_data();

            // Assign values to the instance properties
            $shareData->CompanyId = $row[0];
            $shareData->Company = $row[1];
            $shareData->SharedCompanyid = $row[2];
            $shareData->SharedCompanyname = $row[3];
            $shareData->Percentage = $row[4];
            $shareData->NoShares = $row[5];
            $shareData->SharedHolderType = $row[6];
            $shareData->Regnumber = $row[7];
            $shareData->StockYear = $row[8];
            $shareData->StockYearSpan = $row[9];

            // Save the instance to the database
            $shareData->save();
        }

        return redirect()->route('home');
    }


    public function registermodal(request $request)
    {
        # code...
        $obj = new User();
        $obj->company_name = $request->company_name;   
        $obj->country = $request->country;
        $obj->state = $request->state;
        $obj->city = $request->city;
        $obj->registration_no = $request->registration_no;
        $obj->email = $request->email;
        $obj->phone = $request->phone;
        $obj->zipcode = $request->zipcode;
        $obj->address = $request->address;
        $obj->password = bcrypt($request->password);
        $obj->user_type = 'u';
        $obj->user_status = 'p';    
        $obj->save();
        return redirect(url('/users'));
    }


    public function download(Request $request)
    {
        $company_id = $request->input('id');
        $companies = $request->input('companies_id');
        $years = $request->input('years');


        $company_name = User::where('id', $company_id)->pluck('company_name');
        $sharedCompanyname = User::whereIn('id', $companies)->pluck('company_name')->toArray();
        $regno = User::whereIn('id', $companies)->pluck('registration_no')->toArray();
       
       
        $data = [
            'companyId' => $company_id,
            'companyname' => $company_name,
            'sharedcompanyid' => $companies,
            'sharedCompanyname' => $sharedCompanyname,
            'years' => $years,
            'regno' => $regno
        ];

        $export = new CompanyDataExport($data);
        $fileName = 'company_data.xlsx';


        return  Excel::download($export, $fileName);
         

    }


    public function search(Request $request)
    {
        $companyId = $request->input('company_id');
        $stockYear = $request->input('span_year');

        $companyShareData = company_share_data::where('CompanyId', $companyId)
            ->where('StockYear', $stockYear)
            ->get();

        return response()->json(['companyShareData' => $companyShareData]);
    }



    public function fetchData(Request $request)
    {
        $selectedYears = $request->input('span_year');
        $selectedCompany = $request->input('company_id');

        $data = company_share_data::whereIn('span_year', $selectedYears)
            ->where('company_id', $selectedCompany)
            ->select('sharedcompanyname', 'percentage')
            ->get();

            

        return response()->json($data);
    }
    
    

    public function approve(User $user)
    {
        $user->update(['user_status' => 'a']);

        return redirect()->back();
    }


    public function reject(User $user)
    {
        $user->update(['user_status' => 'r']);
        $user->delete();
        return redirect()->back();
    }


    public function mapping()
    {
        $users = User::where('user_status', 'a')->get();
        return view('mapping', compact('users'));
    }
    public function map_company($companyid)
    {
        # code...

        $companies = User::where('user_status', 'a')
        ->where('user_type','u')
        ->whereNotIn('id', [$companyid])
        ->get();
        return view('map_company',compact('companies'));
    }

    public function mapCompanyDetails(Request $request)
    {
       
        $exist_comapny = company_share_mappings::where('company_id', $request->id)->delete();
        //dd($exist_comapny);

        if (count($request->comapnies_id) > 0 && $request->comapnies_id != null) {
            for ($i = 0; $i < count($request->comapnies_id); $i++) {

                $comapny_share = new company_share_mappings();
                $comapny_share->shared_companies_id = $request->comapnies_id[$i];
                $comapny_share->company_id = $request->id;
                $comapny_share->save();

            }

        }
        return redirect()->back()->with('success', 'Companies mapped');
    }


    public function registerModel()
    {
        # code...
        return view('registerModel');
    }

    

}
