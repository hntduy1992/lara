<?php

namespace App;

use Illuminate\Support\Collection;

class  TreeService
{
    public static function buildTree(Collection $collect, $parentId = null): Collection
    {
        // Lấy các mục có parent_id hiện tại.
        // Nếu không có, trả về một Collection rỗng (collect()).
        $items = $collect;
        return $items->map(function ($item) use ($collect) {
            $data = $item->toArray();
            $children = self::buildTree($collect, $item->id);
            if ($children->isNotEmpty()) {
                $data['children'] = $children->values()->toArray();
                $data['is_parent'] = true; // Cờ báo hiệu mục này có con
            } else {
                $data['is_parent'] = false;
            }
        });
//        return $items->map(function ($item) use ($collect) {
//
//            // Chuyển Model object thành mảng để có thể thêm khóa mới ('children')
//            $data = $item->toArray();
//
//            // Gọi đệ quy để tìm con của mục hiện tại ($item->id)
//            $children = self::buildTree($collect, $item->id);
//
//            // Nếu có con, thêm vào khóa 'children'
//            if ($children->isNotEmpty()) {
//                $data['children'] = $children->values()->toArray();
//                $data['is_parent'] = true; // Cờ báo hiệu mục này có con
//            } else {
//                $data['is_parent'] = false;
//            }
//            return $data;
//        });
    }
}
