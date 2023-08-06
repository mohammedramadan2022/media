<?php

namespace App\Http\Traits\Other;

trait HasDynamicMultiTrans
{
    private static function getLangData($request, $lang, $arr): array
    {
        $data = [];

        $name = $arr . '_' . strtolower($lang);

        foreach ($request->$name as $index => $item)
        {
            $data[$lang][$index] = $item;
        }

        return $data;
    }

    private static function setRows($items, $id_name): array
    {
        $data = [];

        foreach ($items as $i => $item)
        {
            $data[$i] = [
                $id_name => $item->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $data;
    }

    private static function setTranslatedRows($data, $arr, $col1, $col2): array
    {
        $_data = [];

        foreach ($data as $lang => $trans)
        {
            foreach (array_values($trans) as $i => $item)
            {
                $_data[] = [$col1 => $arr[$i]->names()->first()->id, 'locale' => $lang, $col2 => $item];
            }
        }

        return $_data;
    }
}
