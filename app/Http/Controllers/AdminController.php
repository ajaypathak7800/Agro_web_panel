<?php


namespace App\Http\Controllers;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CustomerImport;
use App\Imports\FpoImport;
use App\Exports\FpoExport;
use App\Models\Agricultural;
use App\Exports\CbboOfflineExport;
use App\Imports\CbboOfflineImport; 
use App\Imports\FpoDetailsImport;
use App\Imports\CbboExpertImport;
use App\Exports\CbboExpertExport;
use App\Imports\AgriculturalImport;
use App\Exports\AgriculturalExport;
use App\Imports\CbboUniqueIdMappingImport;
use App\Exports\CbboUniqueIdMappingExport;
use App\Models\CbboExpert;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('layout');
    }

    public function hello()
    {
        return view('report');
    }

    public function index(Request $request)
    {
        if($request->session()->has('ADMIN_LOGIN')){
            return redirect('admin/dashboard');
        }else{
         
      
        return view('login');
    }
}
  
public function auth(Request $request)
{
    $email = $request->post('email');
    $password = $request->post('password');

    // Query the database for the user with the given email
    $user = DB::table('users')->where('email', $email)->first();

    // Ensure the user exists and compare the hashed password
    if ($user && Hash::check($password, $user->password)) {
        // If authentication succeeds
        $request->session()->put('ADMIN_LOGIN', true);
        $request->session()->put('ADMIN_ID', $user->id);
        $request->session()->put('ADMIN_NAME', $user->name); // Store user's name in session
        return redirect('/');
    } else {
        // If authentication fails
        $request->session()->flash('error', 'Please enter valid login details');
        return redirect('admin');
    }
}

public function register(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Insert user data into the 'users' table
            $userId = DB::table('users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Optionally, log the user in after registration
            Auth::loginUsingId($userId);

            // Flash a success message to the session
            return redirect()->back()->with('success', 'Users imported successfully.');

            // Return a success response for the AJAX request with SweetAlert
            return response()->json([
                'message' => 'Registration successful!',
                'alert' => [
                    'icon' => 'success',
                    'title' => 'Success!',
                    'text' => 'Registration successful!',
                ],
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions if user registration fails
            return response()->json(['errors' => ['message' => 'User registration failed']], 422);
        }
    }
public function logout(Request $request)
{
    Auth::logout(); // Logout the user
    $request->session()->invalidate(); // Invalidate the session
    $request->session()->regenerateToken(); // Regenerate CSRF token

    return redirect('/'); // Redirect to home or login page
}

public function import(Request $request)
{
    $users = DB::table('users')->get();
    return view('customer', ['users' => $users]);
   
}
public function importexcel(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    // Use Laravel Excel to import the data from the uploaded file
    Excel::import(new CustomerImport, $request->file('file'));

    return redirect()->back()->with('success', 'Users imported successfully.');
}
public function exportUsers()
{
    try {
        // Get the logged-in user's ID from the session
        $userId = session('ADMIN_ID');

        // Log the export action
        DB::table('user_action_track')->insert([
            'user_id' => $userId,
            'activity_type' => 'export',
            'action_table' => 'users', // Change this to the relevant table name
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Perform the export
        return Excel::download(new UsersExport, 'users.xlsx');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error exporting file: ' . $e->getMessage());
    }
}

public function showUsers()
{
    $users = DB::table('users')->get();
    return view('customer', ['users' => $users]);
}
public function store(Request $request)
{
    DB::table('users')->insert([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    return redirect()->route('users.index');
}
public function indexFPO()
{

    
    $fpos = DB::table('master')->orderBy('implementing_agency', 'asc')->get();
    return view('fpo', compact('fpos'));
}

public function export()
{
    try {
        // Retrieve FPO data from the database
        $fpos = DB::table('master')->get();

        // Log the export action
        $userId = session('ADMIN_ID');
        DB::table('user_action_track')->insert([
            'user_id' => $userId,
            'activity_type' => 'export',
            'action_table' => 'master', // Adjust based on your table or context
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Set a flash message for success
        session()->flash('success', 'File is being downloaded!');

        // Return the file download
        return Excel::download(new FpoExport($fpos), 'fpo.xlsx');
    } catch (\Exception $e) {
        // Handle any exceptions during export
        return redirect()->back()->with('error', 'Error exporting file: ' . $e->getMessage());
    }
}


public function importFPO(Request $request)
{
    // Validate the file and headings parameter
    $request->validate([
        'file' => 'required|mimes:csv,txt,xlsx,xls',
     // Parameter to specify if the file has headings
    ]);

    try {
        // Determine if the file has headings
        $hasHeadingRow = $request->headings;

        // Initialize the import class with the headings parameter
        $importClass = new FpoImport($hasHeadingRow);

        // Import data from the uploaded file
        Excel::import($importClass, $request->file('file')->store('temp'));

        // Log the import action
        $userId = session('ADMIN_ID');
        DB::table('user_action_track')->insert([
            'user_id' => $userId,
            'activity_type' => 'import',
            'action_table' => 'MASTER', // Adjust based on your table name or context
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Users imported successfully.');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        $failures = $e->failures();
        $errorMessages = '';
        foreach ($failures as $failure) {
            $errorMessages .= 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors()) . "\n";
        }
        return redirect()->back()->with('error', 'Validation errors: ' . $errorMessages);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error importing file: ' . $e->getMessage());
    }
}

public function importCbbo(Request $request)
{
    // Validate the file type
    $request->validate([
        'file' => 'required|mimes:xlsx,csv',
    ]);

    try {
        // Import data from the uploaded file
        Excel::import(new CbboExpertImport, $request->file('file')->store('temp'));

        // Log the import action
        $userId = session('ADMIN_ID');
        DB::table('user_action_track')->insert([
            'user_id' => $userId,
            'activity_type' => 'import',
            'action_table' => 'cbbo_expert',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Users imported successfully.');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        $failures = $e->failures();
        $errorMessages = '';
        foreach ($failures as $failure) {
            $errorMessages .= 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors()) . "\n";
        }
        return redirect()->back()->with('error', 'Validation errors: ' . $errorMessages);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error importing file: ' . $e->getMessage());
    }
}

public function exportCbbo()
{
    try {
        // Log the export action
        $userId = session('ADMIN_ID');
        DB::table('user_action_track')->insert([
            'user_id' => $userId,
            'activity_type' => 'export',
            'action_table' => 'cbbo_expert',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Set a session flash message for success
        session()->flash('success', 'File is being downloaded!');

        // Return the file download
        return Excel::download(new CbboExpertExport, 'cbbo_expert.xlsx');
    } catch (\Exception $e) {
        // Handle any exceptions during export
        return redirect()->back()->with('error', 'Error exporting file: ' . $e->getMessage());
    }
}


    public function importExportView()
    {
        $experts = CbboExpert::all();
        return view('importExportView', compact('experts'));
    }
    



public function INDEXUSER()
{
    $users = DB::table('users')->get();
    return view('index',['users' => $users]);
}

//uesview
public function storeg(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    try {
        DB::beginTransaction();

        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
           
        ];

        DB::table('users')->insert($user);

        DB::commit();

        return redirect()->route('INDEXUSER')->with('success', 'User created successfully.');

    } catch (\Exception $e) {
        DB::rollback();
        return back()->withInput()->withErrors(['error' => 'Failed to create user. Please try again.']);
    }
}


public function edit($id)
{
    $user = DB::table('users')->where('id', $id)->first();
    return view('edit', compact('user'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        'password' => 'nullable|string|min:8',
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'updated_at' => now(),
    ];

    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }

    DB::table('users')->where('id', $id)->update($data);

    return redirect()->route('INDEXUSER')->with('success', 'User updated successfully.');
}

public function destroy($id)
{
    DB::table('users')->where('id', $id)->delete();
    return redirect()->route('INDEXUSER')->with('success', 'User deleted successfully.');
}
public function create()
    {
        // Logic to display the create user form or any other setup needed
        return view('create'); // Assuming 'create.blade.php' exists in 'resources/views'
    }
   // expot arricultre
   public function agricultural()
   {
       $agriculturalData = DB::table('agricultural')->get();
       return view('agricultural', compact('agriculturalData'));
   }

   public function importagricultural(Request $request)
   {
       $request->validate([
           'file' => 'required|mimes:xlsx,xls',
       ]);

       Excel::import(new AgriculturalImport, $request->file('file'));

       return redirect()->back()->with('success', 'Data imported successfully.');
   }

   public function exportagricultural()
   {
       return Excel::download(new AgriculturalExport, 'agricultural.xlsx');
   }

//cbboo ofline
public function indexc()
{
    $cbboOfflineData = DB::table('cbbo_offline')->get();
    return view('cbbo_offline', compact('cbboOfflineData'));
}
public function exportb()
{
    try {
        // Generate the download
        $file = Excel::download(new CbboOfflineExport, 'cbbo_offline.xlsx');

        // Retrieve the user ID from the session
        $userId = session('ADMIN_ID');

        // Check if $userId is correctly retrieved
        if (!$userId) {
            throw new \Exception('User ID not found in session');
        }

        // Log the export action
        DB::table('user_action_track')->insert([
            'user_id' => $userId,
            'activity_type' => 'export',
            'action_table' => 'cbbo_offline',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $file;
    } catch (\Exception $e) {
        // Handle any exceptions during download
        return redirect()->back()->with('error', 'Error exporting file: ' . $e->getMessage());
    }
}

public function importb(Request $request)
{
    // Validate the file type
    $request->validate([
        'file' => 'required|mimes:csv,txt,xlsx,xls',
    ]);

    try {
        // Import data from the uploaded file
        Excel::import(new CbboOfflineImport, $request->file('file'));

        // Retrieve the user ID from the session
        $userId = session('ADMIN_ID');

        // Check if $userId is correctly retrieved
        if (!$userId) {
            throw new \Exception('User ID not found in session');
        }

        // Log the import action
        DB::table('user_action_track')->insert([
            'user_id' => $userId,
            'activity_type' => 'import',
            'action_table' => 'cbbo_offline',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('cbbo_offline')->with('success', 'Data imported successfully.');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        $failures = $e->failures();
        $errorMessages = '';
        foreach ($failures as $failure) {
            $errorMessages .= 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors()) . "\n";
        }
        return redirect()->route('cbbo_offline')->with('error', 'Validation errors: ' . $errorMessages);
    } catch (\Exception $e) {
        return redirect()->route('cbbo_offline')->with('error', 'Error importing file: ' . $e->getMessage());
    }
}






public function showLogs(Request $request)
{
    $logs = DB::table('user_action_track')
        ->join('users', 'user_action_track.user_id', '=', 'users.id')
        ->select('user_action_track.*', 'users.name')
        ->orderBy('created_at', 'desc')
        ->paginate(10); // Adjust the number of items per page as needed

    return view('logs', compact('logs'));
}



//importCbboUniqueIdMapping
public function importCbboUniqueIdMapping(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,txt,xlsx,xls',
    ]);

    try {
        // Import data from the uploaded file
        Excel::import(new CbboUniqueIdMappingImport, $request->file('file'));

        // Log the import action
        $userId = session('ADMIN_ID');

        // Debugging: Check if $userId is correctly retrieved
        if (!$userId) {
            throw new \Exception('User ID not found in session');
        }

        DB::table('user_action_track')->insert([
            'user_id' => $userId,
            'activity_type' => 'import',
            'action_table' => 'cbbo_unique_id_mapping',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Data imported successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error importing file: ' . $e->getMessage());
    }
}

public function exportCbboUniqueIdMapping()
{
    try {
        // Get the logged-in user's ID from the session
        $userId = session('ADMIN_ID');

        // Log the export action
        DB::table('user_action_track')->insert([
            'user_id' => $userId,
            'activity_type' => 'export',
            'action_table' => 'cbbo_unique_id_mapping',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return Excel::download(new CbboUniqueIdMappingExport, 'cbbo_unique_id_mapping.xlsx');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error exporting file: ' . $e->getMessage());
    }
}

public function showCbboUniqueIdMapping()
{
    $data = DB::table('cbbo_unique_id_mapping')->get();
    return view('cbbo_unique_id_mapping', compact('data'));
}

//IMPORT FPO DETAILS
public function importFpoDetails(Request $request)
{
    // Validate the file type
    $request->validate([
        'file' => 'required|mimes:xlsx,csv',
    ]);

    try {
        // Import data from the uploaded file
        Excel::import(new FpoDetailsImport, $request->file('file')->store('temp'));

        // Log the import action
        $userId = session('ADMIN_ID');
        DB::table('user_action_track')->insert([
            'user_id' => $userId,
            'activity_type' => 'import',
            'action_table' => 'fpo_details',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Return a response indicating success
        return redirect()->back()->with('success', 'FPO details imported successfully.');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        // Handle validation errors
        $failures = $e->failures();
        $errorMessages = '';
        foreach ($failures as $failure) {
            $errorMessages .= 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors()) . "\n";
        }
        return redirect()->back()->with('error', 'Validation errors: ' . $errorMessages);
    } catch (\Exception $e) {
        // Log and handle other exceptions
        Log::error('Error importing FPO detail: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error importing file: ' . $e->getMessage());
    }
}
public function FPOdetails()
{
    // Fetch data or perform any necessary logic here
    $fpoDetails =DB::table('fpo_details')->get();

    // Return the view with data
    return view('fpo_details', compact('fpoDetails'));
}

}





















