<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Url
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $uid
 * @property string $url
 * @method static \Illuminate\Database\Query\Builder|\App\Url whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Url whereUid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Url whereUrl($value)
 */
class Url extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['url'];

    /**
     * Character map which is used to convert between text and numeric form of id.
     *
     * @var string
     */
    const CHARACTER_MAP = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    /**
     * Returns text url id converted from numeric form.
     *
     * @return string
     */
    public function getTextId()
    {
        $b = strlen(self::CHARACTER_MAP);
        $r = $this->id % $b;
        $res = self::CHARACTER_MAP[$r];
        $q = floor($this->id / $b);

        while ($q) {
            $r = $q % $b;
            $q = floor($q / $b);
            $res = self::CHARACTER_MAP[$r] . $res;
        }

        return $res;
    }

    /**
     * Returns numeric url id converted from text form.
     *
     * @param string $s
     * @return int
     */
    public static function convertToInt(string $s)
    {
        $b = strlen(self::CHARACTER_MAP);
        $limit = strlen($s);
        $res = strpos(self::CHARACTER_MAP, $s[0]);

        for ($i = 1; $i < $limit; $i++) {
            $res = $b * $res + strpos(self::CHARACTER_MAP, $s[$i]);
        }

        return $res;
    }
}
