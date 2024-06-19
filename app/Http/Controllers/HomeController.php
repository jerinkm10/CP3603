<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Redirect;
use Session;
use View;
use Illuminate\Support\Facades\Log;
use DB;
use Mail;
use App\Models\Form;
use App\Models\FormField;
use App\Models\FormData;
use App\Jobs\SendFormCreatedNotification;
class HomeController extends Controller
{
   public function home(){
       $users = DB::table('users')
                   ->select('*')
                   ->get();
                  // dd($users);   
        return view('theme.index',['users'=>$users]);
        
   }
     public function showForm()
    {
        return view('add-form');
    }

    public function saveForm(Request $request) {
        $validatedData = $request->validate([
            'form_name' => 'required|string|max:255',
            'label' => 'required|array',
            'label.*' => 'required|string|max:255',
            'inputType' => 'required|array',
            'inputType.*' => 'required|string|max:255',
            'inputTypeOption' => 'array',
        ]);

        $form = new Form();
        $form->name = $validatedData['form_name'];
        $form->save();

        $labels = $validatedData['label'];
        $inputTypes = $validatedData['inputType'];
        $inputTypeOptions = $request->input('inputTypeOption', []);

        foreach ($labels as $index => $label) {
            $formField = new FormField();
            $formField->form_id = $form->id;
            $formField->label = $label;
            $formField->input_type = $inputTypes[$index];
            $formField->input_type_options = isset($inputTypeOptions[$index]) ? json_encode($inputTypeOptions[$index]) : null;
            $formField->save();
        }

        // Dispatch the job to send email notification
        SendFormCreatedNotification::dispatch($form);

        return response()->json([
            'success' => true,
            'message' => 'Form saved successfully!',
            'form_id' => $form->id,
        ]);
    }
    public function getForms() {
        $forms = Form::with('fields', 'form_data')->get();
        return response()->json(['forms' => $forms]);
    }
    
    public function getForm($id) {
        $form = Form::with('fields')->find($id);
         // Retrieve associated form data
        $formData = FormData::where('form_id', $id)->get();

        // Attach form data to the form object
        $form->form_data = $formData;
        return response()->json(['form' => $form]);
    }
    
    public function updateForm(Request $request) {
      $form = Form::find($request->form_id);
      //$form->name = $request->input('form_name');
      $form->save();
      
      // Update form fields
      FormField::where('form_id', $form->id)->delete();
      $labels = $request->input('editlabel');
      $inputTypes = $request->input('editinputType');
      $inputTypeOptions = $request->input('editinputTypeOption',[]);
      $optionKeys = array_keys($inputTypeOptions);
      foreach ($labels as $index => $label) {
          // Ensure the $inputTypes array has an entry for this index
          if (!isset($inputTypes[$index])) {
            continue; // Skip this iteration if no corresponding input type
        }
    
        $formField = new FormField();
        $formField->form_id = $form->id;
        $formField->label = $label;
        $formField->input_type = $inputTypes[$index];
        // Ensure the $inputTypeOptions array has an entry for this index
        if (isset($inputTypeOptions[$index]) && !empty($inputTypeOptions[$index])) {
            $formField->input_type_options = json_encode($inputTypeOptions[$index]);
        } else {
            $formField->input_type_options = null; // Set to null if no options are provided
        }
          $formField->save();
      }
    
        return response()->json(['success' => true, 'message' => 'Form updated successfully!']);
    }
    
    public function deleteForm($id) {
        $form = Form::find($id);
        $form->delete();
    
        return response()->json(['success' => true, 'message' => 'Form deleted successfully!']);
    }
    public function getUsers(){
      $users = DB::table('users')
      ->select('*')
      ->get();
 
      return view('theme.user',['users'=>$users]);
    }
    public function saveFormData(Request $request)
    {
     
        $validatedData = $request->validate([
            'form_id' => 'required|exists:forms,id',
            'fields' => 'required|array'
        ]);
       
        $formId = $validatedData['form_id'];
        $fields = $validatedData['fields'];
        
        // Loop through the fields and save the form data
        foreach ($fields as $fieldId => $fieldValue) {
            $formField = FormField::find($fieldId);
            if ($formField) {
                $formData = new FormData(); // Assuming you have a FormData model to store form data
                $formData->form_id = $formId;
                $formData->field_id = $fieldId;
                $formData->value = is_array($fieldValue) ? json_encode($fieldValue) : $fieldValue;
                $formData->save();
            }
        }
        session()->flash('success', 'Form data saved successfully!');
        Log::info('Success message set in session: ' . session('success'));
        return redirect()->back();
        //return redirect()->back()->with('success', 'Form data saved successfully!');
    }
    
  
}