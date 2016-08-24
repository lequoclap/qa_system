<?php

namespace App\Console\Commands;

use App\Models\ItemBrand;
use App\Models\ItemCategory;
use App\Models\ItemCondition;
use App\Models\ItemSize;
use App\Models\ItemSizeGroup;
use App\Models\ShippingDuration;
use App\Models\ShippingFromArea;
use App\Models\ShippingMethod;
use App\Models\ShippingPayer;
use App\Models\User;
use Classes\MercariAPIClient;

class OneTimeInitData extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'onetimeInitData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function doCommand()
    {
        //get first user
        $user = User::first();
        $client = new MercariAPIClient($user->access_token, $user->global_access_token);

        $categories = $client->getItemCategories();
        $this->storeItemCategories($categories['data']);

        $itemSizes = $client->getItemSizes();
        $this->storeItemSizeGroups($itemSizes['data']['ItemSizeGroups']);
        $this->storeItemSizes($itemSizes['data']['ItemSizes']);

        $itemBrandGroups = $client->getItemBrandGroups();
        $this->storeItemBrand($itemBrandGroups['data']);

        $itemConditions = $client->getItemConditions();
        $this->storeItemConditions($itemConditions['data']);

        $shippingPayers = $client->getShippingPayers();
        $this->storeShippingPayers($shippingPayers['data']);

        $shippingFromAreas = $client->getShippingFromAreas();
        $this->storeShippingFromAreas($shippingFromAreas['data']);

        $shippingMethods = $client->getShippingMethods();
        $this->storeShippingMethods($shippingMethods['data']['ShippingMethods']);

        $shippingDurations = $client->getShippingDurations();
        $this->storeShippingDurations($shippingDurations['data']);
    }

    /**
     * @param $categories
     */
    protected function storeItemCategories($categories)
    {
        foreach ($categories as $categoryData) {
            $category = ItemCategory::find($categoryData['id']);
            if ($category) {
                continue;
            }
            $category = new ItemCategory();
            $category->id = $categoryData['id'];
            $category->name = $categoryData['name'];
            $category->root_category_id = isset($categoryData['root_category_id']) ? $categoryData['root_category_id'] : 0;
            $category->parent_category_id = isset($categoryData['parent_category_id']) ? $categoryData['parent_category_id'] : 0;
            $category->size_group_id = isset($categoryData['size_group_id']) ? $categoryData['size_group_id'] : 0;
            $category->brand_group_id = isset($categoryData['brand_group_id']) ? $categoryData['brand_group_id'] : 0;
            $category->save();

            if (isset($categoryData['child'])) {
                $this->storeItemCategories($categoryData['child']);
            }
        }
    }

    /**
     * @param $sizeGroups
     */
    protected function storeItemSizeGroups($sizeGroups)
    {
        foreach ($sizeGroups as $sizeGroupData) {
            $sizeGroup = ItemSizeGroup::find($sizeGroupData['id']);
            if ($sizeGroup) {
                continue;
            }
            $sizeGroup = new ItemSizeGroup();
            $sizeGroup->id = $sizeGroupData['id'];
            $sizeGroup->name = $sizeGroupData['name'];
            $sizeGroup->save();
        }
    }

    /**
     * @param $itemSizes
     */
    protected function storeItemSizes($itemSizes)
    {
        foreach ($itemSizes as $sizeGroupId => $sizeDatas) {
            foreach ($sizeDatas as $sizeData) {
                $size = ItemSize::find($sizeData['id']);
                if ($size) {
                    continue;
                }
                $size = new ItemSize();
                $size->id = $sizeData['id'];
                $size->name = $sizeData['name'];
                $size->size_group_id = $sizeGroupId;
                $size->save();
            }
        }
    }

    /**
     * @param $brandDatas
     */
    protected function storeItemBrand($brandDatas)
    {
        foreach ($brandDatas as $groupId => $datas) {
            foreach ($datas as $data)
            {
                foreach ($data['brands'] as $brandData) {
                    $brand = ItemBrand::find($brandData['id']);
                    if ($brand) {
                        continue;
                    }
                    $brand = new ItemBrand();
                    $brand->id = $brandData['id'];
                    $brand->name = $brandData['name'];
                    $brand->sub_name = $brandData['sub_name'];
                    $brand->initial = $data['brand_initial'];
                    $brand->group_id = $groupId;
                    $brand->save();
                }
            }
        }
    }

    /**
     * @param $conditionDatas
     */
    protected function storeItemConditions($conditionDatas)
    {
        foreach ($conditionDatas as $data) {
            $condition = ItemCondition::find($data['id']);
            if ($condition) {
                continue;
            }
            $condition = new ItemCondition();
            $condition->id = $data['id'];
            $condition->name = $data['name'];
            $condition->save();
        }
    }

    /**
     * @param $shippingPayerDatas
     */
    protected function storeShippingPayers($shippingPayerDatas)
    {
        foreach ($shippingPayerDatas as $data) {
            $shippingPayer = ShippingPayer::find($data['id']);
            if ($shippingPayer) {
                continue;
            }
            $shippingPayer = new ShippingPayer();
            $shippingPayer->id = $data['id'];
            $shippingPayer->name = $data['name'];
            $shippingPayer->code = $data['code'];
            $shippingPayer->save();
        }
    }

    /**
     * @param $shippingAreaDatas
     */
    protected function storeShippingFromAreas($shippingAreaDatas)
    {
        foreach ($shippingAreaDatas as $data) {
            $shippingArea = ShippingFromArea::find($data['id']);
            if ($shippingArea) {
                continue;
            }
            $shippingArea = new ShippingFromArea();
            $shippingArea->id = $data['id'];
            $shippingArea->name = $data['name'];
            $shippingArea->save();
        }
    }

    /**
     * @param $shippingMethodDatas
     */
    protected function storeShippingMethods($shippingMethodDatas)
    {
        foreach ($shippingMethodDatas as $code => $datas) {
            foreach ($datas as $data) {
                $shippingMethod = ShippingMethod::find($data['id']);
                if ($shippingMethod) {
                    continue;
                }
                $shippingMethod = new ShippingMethod();
                $shippingMethod->id = $data['id'];
                $shippingMethod->name = $data['name'];
                $shippingMethod->code = $code;
                $shippingMethod->save();
            }
        }
    }

    /**
     * @param $shippingDurationDatas
     */
    protected function storeShippingDurations($shippingDurationDatas)
    {
        foreach ($shippingDurationDatas as $data) {
            $shippingDuration = ShippingDuration::find($data['id']);
            if ($shippingDuration) {
                continue;
            }
            $shippingDuration = new ShippingDuration();
            $shippingDuration->id = $data['id'];
            $shippingDuration->name = $data['name'];
            $shippingDuration->min_days = $data['min_days'];
            $shippingDuration->max_days = $data['max_days'];
            $shippingDuration->save();
        }
    }
}
