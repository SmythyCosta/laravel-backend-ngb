<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Models\Supplier;
use App\Models\Setting;
use App\LibPDF\SupplierPDF;

//libs
use Excel;

class SupplierController extends Controller
{
    //
    public function getAllSupplier(Request $request)
    {
        $all = Supplier::select('id','company','name','email','phone','status')->orderBy('id','DESC')->get();           
        return response()->json(['status'=>200,'supplier'=>$all]); 
    }

    public function getSupplier(Request $request)
    {
        $id = $request->input('id');
        $supplier = Supplier::find($id); 
        $data = [
            'id' => $supplier->id,
            'company' => $supplier->company,
            'name' => $supplier->name,
            'email' => $supplier->email,
            'phone' => $supplier->phone,
            'status' => $supplier->status,
            'image' => base64_encode($supplier->image)
        ];          
        return response()->json(['status'=>200,'supplier'=>$data]); 
    }

    public function supplierSave(Request $request)
    {
        $supplier = new Supplier;
        $supplier->name = $request->input('name');
        $supplier->company = $request->input('company');
        $supplier->email = $request->input('email');
        $supplier->phone = $request->input('phone');
        $supplier->status = $request->input('status');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $supplier->image = $contents;
        }
        
        $supplier->save();
        return response()->json(['status'=>200,'mesg'=>'Supplier Save Success']); 
    }

    public function supplierUpdate(Request $request)
    {
        $id = $request->input('id');
        $supplier = Supplier::find($id);
        $supplier->name = $request->input('name');
        $supplier->company = $request->input('company');
        $supplier->email = $request->input('email');
        $supplier->phone = $request->input('phone');
        $supplier->status = $request->input('status');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $supplier->image = $contents;
        }
        $supplier->save();
        return response()->json(['status'=>200,'mesg'=>'Supplier Update Success']); 
    }

    public function getSupplierInfo(Request $request)
    {
        $id = $request->input('id');
        $supplier = Supplier::select('id','company','name','email','phone','status','image')->where('id',$id)->first();
        $purchase = DB::table('purchase')->select(DB::raw('DATE_FORMAT(created_at,"%d %M %Y") as date'),'id','purchase_code')->where('supplier_id',$id)->get();

        $purchaseInfo = '';

        foreach ($purchase as $key => $value) {
 
            $payment = DB::table('payment')->select('id',DB::raw('SUM(amount) as totalAmount'))->where('purchase_id',$value->id)->first();
            $purchaseInfo[] = [
                'id' =>$value->id,
                'purchase_code' =>$value->purchase_code,
                'amount' => $payment->totalAmount,
                'date' => $value->date
            ];
        }
       
        $supplierData = [
            'id' => $supplier->id,
            'company' => $supplier->company,
            'name' => $supplier->name,
            'email' => $supplier->email,
            'phone' => $supplier->phone,
            'status' => $supplier->status,
            'image' => base64_encode($supplier->image)
        ];
        return response()->json(['status'=>200,'supplier'=>$supplierData,'purchase'=>$purchaseInfo]); 
    }

    public function exportpdf(Request $request)
    {
        $allSupplier = Supplier::all();
        $setting = Setting::where('id',1)->first();
        $pdf = new SupplierPDF();
        $pdf->SetMargins(50, 10, 11.7);
        $pdf->AliasNbPages();
        $pdf->AddPage();
    
        $pdf->SetFont('Arial','B',12);
        // $pdf->Cell(5);
        $pdf->Cell(200,5,'Supplier Record List',0,1,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(200,5,$setting->company_name,0,1,'L');
        $pdf->Cell(200,5,$setting->phone,0,1,'L');
        $pdf->Cell(200,5,$setting->address,0,1,'L');
        $pdf->Cell(200,5,'Currency : '.$setting->currency,0,1,'L');
        $pdf->Ln(10);

        $pdf->SetFont('Arial','B',12);
        $pdf->cell(15,6,"SL",1,"","C");
        $pdf->cell(45,6,"Company",1,"","C");
        $pdf->cell(45,6,"Name",1,"","C");
        $pdf->cell(45,6,"Email",1,"","C");
        $pdf->cell(30,6,"Phone",1,"","C");
        $pdf->cell(30,6,"Status",1,"","C");
        $pdf->Ln();
        $pdf->SetFont('Times','',10);
        /*for($i=1;$i<=40;$i++)
        $pdf->Cell(0,10,'Printing line number '.$i,0,1);
        $pdf->Ln();
        $pdf->SetFont("Arial","",10);*/
        foreach ($allSupplier as $key => $value) {
            $pdf->cell(15,5,$key,1,"","C");
            $pdf->cell(45,5,$value->company,1,"","L");
            $pdf->cell(45,5,$value->name,1,"","L");
            $pdf->cell(45,5,$value->email,1,"","L");
            $pdf->cell(30,5,$value->phone,1,"","L");
            $pdf->cell(30,5,(($value->status==1) ? 'Active' : 'Deactive'),1,"","L");
            $pdf->Ln();
        }
        $pdf->Output();
        exit;
    }

    public function downloadExcel()
    {
        $type = 'xlsx';
        $data = Supplier::get()->toArray();
        $setting = Setting::where('id',1)->first();
        Excel::create('Supplier-record-list', function ($excel) {
            $excel->setTitle('Supplier Record List');

            // Chain the setters
            $excel->sheet('Supplier-record', function ($sheet) {

                // first row styling and writing content
                $sheet->mergeCells('A1:E1');
                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Comic Sans MS');
                    $row->setFontSize(30);
                    // $row->setBorder('solid', 'none', 'none', 'solid');
                });
                // $sheet->setBorder('A1:F1', 'thin');

                // Set all borders (top, right, bottom, left)
                // $cells->setBorder('solid', 'none', 'none', 'solid');
                $sheet->row(1, array('Supplier Record List'));

                // second row styling and writing content
                /*$sheet->row(2, function ($row) {

                    // call cell manipulation methods
                    $row->setFontFamily('Comic Sans MS');
                    $row->setFontSize(15);
                    $row->setFontWeight('bold');

                });*/

                // $sheet->row(2, array('Something else here'));

                // getting data to display - in my case only one record
                $users = Supplier::get()->toArray();

                // setting column names for data - you can of course set it manually
                //$sheet->appendRow(array_keys($users[0])); // column names

                $sheet->appendRow(2,
                                    array(
                                        'ID',
                                        'Company Name',
                                        'Name',
                                        'Email',
                                        'Phone',
                                        'Status'
                                        )
                                    );

                // getting last row number (the one we already filled and setting it to bold
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontWeight('bold');
                    $row->setAlignment('center');
                    $row->setBorder('thin', 'thin', 'thin', 'thin');
                });

                // putting users data as next rows
                foreach ($users as $user) {

                    $sheet->appendRow(
                                    array(
                                        $user['id'],
                                        $user['company'],
                                        $user['name'],
                                        $user['email'],
                                        $user['phone'],
                                        (($user['status']==1) ? 'Active' : 'Deactive')
                                        )
                                    );
                    $sheet->row($sheet->getHighestRow(), function ($row) {
                        $row->setAlignment('center');
                        $row->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                }

                // die();
            });

        })->export('xls');
    }


}
