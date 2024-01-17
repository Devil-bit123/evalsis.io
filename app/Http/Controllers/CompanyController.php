<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 * Class CompanyController
 * @package App\Http\Controllers
 */
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::paginate();

        return view('company.index', compact('companies'))
            ->with('i', (request()->input('page', 1) - 1) * $companies->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = new Company();
        return view('company.create', compact('company'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(Company::$rules);


        if(!$validatedData){
            return redirect()->route('company.create')
            ->withErrors(['error' => 'No se pudo guardar el registro. Por favor, revisa los datos e intenta nuevamente.'])
            ->withInput(); // Mantener los datos ingresados en el formulario.
        }
        //dd($request);
        $data = $request->all();
        DB::table('companies')->insert([
            'info' => json_encode($data['info']),
        ]);
        return redirect()->route('voyager.custom-dashboards.index')
            ->with('success', 'Company created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);

        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);

        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Company $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        request()->validate(Company::$rules);

        $company->update($request->all());

        return redirect()->route('companies.index')
            ->with('success', 'Company updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $company = Company::find($id)->delete();

        return redirect()->route('companies.index')
            ->with('success', 'Company deleted successfully');
    }
}
