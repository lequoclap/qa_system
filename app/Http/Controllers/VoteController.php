<?php


namespace App\Http\Controllers;


use Laracasts\Flash\Flash;

class VoteController extends BaseController
{

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function listPage()
    {
        $mitems = MercariItem::join('items', 'mercari_items.item_id', '=', 'items.id')
            ->where(['items.user_id' => \Auth::user()->id])
            ->selectRaw('mercari_items.*,items.name,items.description')
            ->get();

        return \View::make('mitem.list', ['items' => $mitems]);
    }

    /**
     * @param $m_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stop($m_id)
    {
        $mItem = MercariItem:: where('m_item_id', $m_id)->first();
        $client = self::getMercariInstant();
        $result = $client->updateStatus($mItem, MercariItem::STATUS_STOP);
        if (array_key_exists('error', $result)) {
            Flash::error($result['error'][0]['message']);
        } else {
            $mItem->status = 'stop';
            $mItem->save();
        }
        return redirect()->route('m_item_list');
    }

    /**
     * @param $m_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($m_id)
    {
        $mItem = MercariItem:: where('m_item_id', $m_id)->first();
        $client = self::getMercariInstant();
        $result = $client->updateStatus($mItem, MercariItem::STATUS_CANCEL);
        if (array_key_exists('error', $result)) {
            Flash::error($result['error'][0]['message']);
        } else {
            $mItem->delete();
        }
        return redirect()->route('m_item_list');
    }

    /**
     * @param $m_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reSell($m_id)
    {
        $mItem = MercariItem:: where('m_item_id', $m_id)->first();
        $client = self::getMercariInstant();
        $result = $client->updateStatus($mItem, MercariItem::STATUS_SELLING);
        if (array_key_exists('error', $result)) {
            Flash::error($result['error'][0]['message']);
        } else {
            $mItem->status = 'on_sale';
            $mItem->save();
        }
        return redirect()->route('m_item_list');
    }

    public function getItemDetail($m_id){
        if (!\Auth::check()) {
            return redirect()->route('m_item_list');
        }
        $user = \Auth::user();
    }
}