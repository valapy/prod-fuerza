<?php

namespace App\Http\Controllers;

use App\Content;
use App\BudgetRequest;
use App\HomeCarousel;
use App\InformationBlock;
use App\News;
use App\Office;
use App\Product;
use App\ProductImage;
use App\UsedProduct;

use Illuminate\Support\Facades\Mail;
// use App\Mail\Mail;
use App\Mail\PilotEmail;
use App\Mail\ContactEmail;
use Exception;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function data() {
        $home = [
            'carousel' => HomeCarousel::select('media', 'media_mobile', 'url')->orderBy('order')->get(),
            'content' => InformationBlock::where('source', 'home')->orderBy('id')->get(),
        ];

        foreach ($home['content'] as $i=>$v):
            try {
                $home['content'][$i]->data = json_decode($v->data);
            } catch (Exception $e) {}
        endforeach;

        $product_categories = Product::categories();
        $product_brakes = Product::brakes();
        $product_engines = Product::engines();
        $product_tires = Product::tires();

        $products = Product::where('active', true)->orderBy('model')->get()->toArray();

        foreach ($products as $i=>$v):
            $products[$i]['spot_price2'] = 99;
            $products[$i]['specs'] = json_decode($products[$i]['specs']);
            $products[$i]['pricing'] = json_decode($products[$i]['pricing']);
            if($products[$i]['pricing'][0]->field=='Contado'){
                $products[$i]['spot_price2'] = $products[$i]['pricing'][0]->value;
            }
            $products[$i]['moneda'] = $products[$i]['pricing'][2]->value;
            $products[$i]['descriptions'] = InformationBlock::where('source_id', $v['id'])->where('source', 'products')->orderBy('id')->get();
            // dd( json_decode($products[$i]['pricing']));
            
            foreach ($products[$i]['descriptions'] as $j=>$v):
                $products[$i]['descriptions'][$j]->data = json_decode($v->data);
            endforeach;

            $products[$i]['product_image'] = count($products[$i]['colors']) > 0 ? $products[$i]['colors'][0]['image'] : null;
        endforeach;

        $news = News::orderBy('date', 'desc')->get();

        $tmp = Content::all();
        $content = [];

        foreach ($tmp as $row):
            $content[$row['key']] = $row;
            unset($content[$row['key']]['key']);
        endforeach;

        $used_products = UsedProduct::orderBy('model')->get()->toArray();
        $branch_offices = Office::where('type', 'branch_offices')->get();
        $garages = Office::where('type', 'garages')->get();

        // dd($products);
        return compact(
            'branch_offices',
            'content',
            'home',
            'garages',
            'news',
            'product_brakes',
            'product_categories',
            'product_engines',
            'product_tires',
            'products',
            'used_products'
        );
    }

    public function budgets(Request $request) {

        
        $data = BudgetRequest::create([
            'office_id' => $request->get('office_id'),
            'name' => $request->get('firstname')." ".$request->get('lastname'),
            'product_of_interest' => $request->get('product_of_interest'),
            'contact_method' => $request->get('contact_method'),
            'contact_value' => $request->get('contact_value'),
            'message' => $request->get('message')
            ]);

            
            $office = Office::find($data->office_id);
            $data->office = $office;
            
            if ($office != null && $office->email != null && strlen($office->email) > 0) {
                Mail::to($office->email)->send(new PilotEmail($data));
                // Mail::to('honda.web.sh.diesasa@myworkplace.com.ar')->send(new PilotEmail($data));
            }else{
                Mail::to('honda.web.sh.diesasa@myworkplace.com.ar')->send(new PilotEmail($data));
            }


            // dd($request->get('office_id'));
            
            
        // $message = $request->get('message');
        // $product_of_interest = $request->get('product_of_interest');
        // $office = Office::find($request->get('office_id'));

        // $notes = "Producto de interes: $product_of_interest
        // Sucursal cercana: $office

        // $message";

        // $lead = [
        //     'action' => 'create',
        //     'appkey' => env('PILOT_APP_KEY'),
        //     'debug' => env('PILOT_DEBUG', 1),
        //     'pilot_suborigin_id' => env('PILOT_SUBORIGIN_ID'),
        //     'pilot_firstname' => $request->get('firstname'),
        //     'pilot_lastname' => $request->get('lastname'),
        //     'pilot_contact_type_id' => 1,
        //     'pilot_business_type_id' => 1,
        //     'pilot_notes' => $notes,
        //     'pilot_country' => 'Paraguay',
        //     'pilot_city' => $request->get('city'),
        //     'pilot_provider_url' => 'http://hondamotos.com.py',
        // ];

        // switch($request->get('contact_method')) {
        // case 'phone':
        //     $lead['pilot_phone'] = $request->get('contact_value');
        //     break;
        // case 'email':
        //     $lead['pilot_email'] = $request->get('contact_value');
        //     break;
        // case 'whatsapp':
        //     $lead['pilot_cellphone'] = $request->get('contact_value');
        //     break;
        // default:
        //     break;
        // }

        // $encoded = "";

        // foreach($lead as $k=>$v):
        //     $encoded .= urlencode($k).'='.urlencode($v).'&';
        // endforeach;

        // $curl = curl_init("https://api.pilotsolution.com.ar/webhooks/welcome.php");
        // curl_setopt($curl, CURLOPT_FAILONERROR, true);
        // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($curl, CURLOPT_HEADER, 0);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $encoded);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // $res = curl_exec($curl);
        // curl_close($curl);

        // try {
        //     $res = json_decode($res);
        //     if ($res->success == true) {
        //         return Response('Ok', 204);
        //     } else {
        //         return Response(json_encode($res), 400);
        //     }
        // } catch (Exception $e) {
        //     return Response(json_encode($e), 400);
        // }



    }

    public function contact(Request $request) {
        $data = new \stdClass();
        $data->firstname = $request->get('firstname');
        $data->lastname = $request->get('lastname');
        $data->email = $request->get('email');
        $data->phone = $request->get('phone');
        $data->message = $request->get('message');

        Mail::to(env('MAIL_CONTACT', 'no-reply@diesa.com.py'))->send(new ContactEmail($data));

        return Response('OK', 204);
      }

    public function downloadPDF(Request $request) {
        // TODO: https://github.com/tecnickcom/tcpdf
    }
}
