<?php
/**
 * Created by IntelliJ IDEA.
 * User: LeTung
 * Date: 西暦16/07/02
 * Time: 19:55
 */

namespace App\Http\Controllers;

use App\Models\MercariItem;
use App\Models\User;
use Illuminate\Http\Request;
use League\Csv\Reader;
use App\Models\Item;
use Laracasts\Flash\Flash;

class ItemsController extends BaseController
{

    public function addItemPage()
    {
        return \View::make('item.add_item_page');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function editItem(Request $request)
    {
        $client = self::getMercariInstant();
        $image_1 = $request->file('photo_1');
        var_dump($image_1);
        $item = new Item();
        $item->item_id = $request->get('id');
        $item->brand_id = $request->get('brand');
        $item->category_id = $request->get('category');
        $item->description = $request->get('description');
        $item->item_condition = $request->get('condition');
        $item->name = $request->get('name');
        $item->price = $request->get('price');
        $item->shipping_duration_id = $request->get('shipping_duration');
        $item->ship_from_area_id = $request->get('shipping_from_area');
        $item->shipping_method_id = $request->get('shipping_method');
        $item->shipping_payer_id = $request->get('shipping_payer');
        $item->image_1 = $item->item_id . "_1.jpg";

        copy(
            $image_1->getPathname(),
            public_path('images/product_image/') . $item->item_id . "_1.jpg"
        );

        $updatedItem = $client->editItem($item);

        return redirect()->route('item_list');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function editItemPage($id)
    {
        $get_item_params = [
            'id' => $id,
            '_access_token' => 'cdbdc2bba6a3bb22a87e00553b0d37a6b1fa6e46',
            '_global_access_token' => 'eyJhbGciOiJFUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE0Njc1MTgwMDAsImd1aWQiOiI3M2Q1YTY0Yy0zYThkLTExZTYtYmY2Ni00NDhhNWIzNzM1MzQiLCJpYXQiOjE0Njc1MTYyMDAsImp0aSI6IjdkZWRhNmNkLTQwY2QtMTFlNi04ZDM2LTQ0OGE1YjM3MzUzNCIsImtpbmQiOiJhY2Nlc3NfdG9rZW4iLCJydGlkIjoiN2RlZDllZDctNDBjZC0xMWU2LThkMzYtNDQ4YTViMzczNTM0Iiwic2VydmljZXMiOlt7InNlcnZpY2VOYW1lIjoibWVyY2FyaS1qcCIsInNlcnZpY2VJRCI6IjE0NDY1NjA3OSJ9XX0.mHOJHFp-246BJi_FejZkUwfI81I2unfrWaaFnyTbVwHvAsMJLJiBn8ZdgZn15stPgh5OaXq4MrT9L6jeDfIsTA'
        ];

        $param = [
            '_access_token' => 'cdbdc2bba6a3bb22a87e00553b0d37a6b1fa6e46',
            '_global_access_token' => 'eyJhbGciOiJFUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE0Njc1MTgwMDAsImd1aWQiOiI3M2Q1YTY0Yy0zYThkLTExZTYtYmY2Ni00NDhhNWIzNzM1MzQiLCJpYXQiOjE0Njc1MTYyMDAsImp0aSI6IjdkZWRhNmNkLTQwY2QtMTFlNi04ZDM2LTQ0OGE1YjM3MzUzNCIsImtpbmQiOiJhY2Nlc3NfdG9rZW4iLCJydGlkIjoiN2RlZDllZDctNDBjZC0xMWU2LThkMzYtNDQ4YTViMzczNTM0Iiwic2VydmljZXMiOlt7InNlcnZpY2VOYW1lIjoibWVyY2FyaS1qcCIsInNlcnZpY2VJRCI6IjE0NDY1NjA3OSJ9XX0.mHOJHFp-246BJi_FejZkUwfI81I2unfrWaaFnyTbVwHvAsMJLJiBn8ZdgZn15stPgh5OaXq4MrT9L6jeDfIsTA'
        ];

        $client = self::getMercariInstant();

        $item_detail = $client->get('items/get', $get_item_params);
        $shipping_duration = $client->get('/master/get_shipping_durations', $param);
        $shipping_from_area = $client->get('/master/get_shipping_from_areas', $param);
        $shipping_condition = $client->get('/master/get_shipping_from_areas', $param);
        $payerAndMethod = $client->get('/master/get_shipping_methods', $param);
        return \View::make('product.edit_item', [
            'item' => $item_detail['data'],
            'shippingDurations' => $shipping_duration['data'],
            'shippingAreas' => $shipping_from_area['data'],
            'shippingMethods' => $payerAndMethod['data']['ShippingMethods']['buyer'],
            'shippingPayers' => $payerAndMethod['data']['ShippingPayers'],
            'conditions' => $shipping_condition['data']

        ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addItems(Request $request)
    {
        $this->validate($request, [
            'csv_file' => 'file|required',
            'data_type' => 'required'
        ]);
        $data_type = $request->get('data_type');
        $user = \Auth::user();
        $file = $request->file('csv_file');
        # unzip data
        try {
            $zip = new \ZipArchive;
            $res = $zip->open($file->getPathname());
            $user_path = sprintf('/images/product_image/%s/', $user->id);
            if ($res === TRUE) {
                $zip->extractTo(public_path($user_path));
                $zip->close();
                if (file_exists(public_path($user_path . '/item.csv'))) {
                    $data = file_get_contents(public_path($user_path . '/item.csv'));
                    if ($data_type == 'replace') {
                        $user->items()->delete();
                    }
                } else {
                    Flash::error('CSV ファイルが正しくない');
                    throw new \Exception();
                }
            } else {
                Flash::error('ZIP ファイルが正しくない');
                throw new \Exception();
            }
        } catch (\Exception $e) {
            return redirect()->route('add_item');
        }

        $data = mb_convert_encoding($data, 'UTF-8', 'Shift-JIS');
        $order = array("\r\n", "\n", "\r");
        $replace = "\n";
        $data = str_replace($order, $replace, $data);
        $csv = Reader::createFromString($data);
        $result = $csv->fetchAll();

        $i = 0;
        foreach ($result as $row) {
            #skip header
            if ($i == 0) {
                $i++;
                continue;
            }
            #skip blank line
            if (strlen($row[1]) == 0 && strlen($row[2]) == 0)
                continue;
            $item = new Item();
            $item->sale_setting = $row[17];
            $item->del_setting = $row[18];
            $item->name = $row[1];
            $item->description = $row[2];
            $item->category_id = $row[3];
            $item->item_condition = $row[6];
            $item->transport_fee_include = $row[7];
            $item->ship_from_area_id = $row[9];
            $item->days_to_release = $row[10];
            $item->shipping_method_id = $row[8];
            $item->price = $row[11];
            $item->image_1 = $row[13];
            $item->image_2 = $row[14];
            $item->image_3 = $row[15];
            $item->image_4 = $row[16];
            $item->user()->associate($user);
            $item->save();
        }
        return redirect()->route('item_list');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function listPage()
    {
        $items = \Auth::user()->items()->get();
        return \View::make('item.list', ['items' => $items]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postItem($id)
    {
        $item = Item::find($id);
        $client = self::getMercariInstant();
        $response = $client->postItem($item);

        $mercari_item = new MercariItem();
        $item_data = $response['data'];
        $mercari_item->m_item_id = $item_data['id'];
        $mercari_item->status = $item_data['status'];
        $mercari_item->num_like = $item_data['num_likes'];
        $mercari_item->num_comment = $item_data['num_comments'];
        $mercari_item->item()->associate($item);
        $mercari_item->save();

        return redirect()->route('m_item_list');
    }

}