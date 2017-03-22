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

    /**
     * Returns extracted URL components from given string.
     * May return null on invalid url.
     *
     * @param string $url
     * @return array|bool
     */
    public static function toComponents(string $url)
    {
        $acceptable_components = [
            'scheme' => PHP_URL_SCHEME,
            'host' => PHP_URL_HOST,
            'path' => PHP_URL_PATH,
            'query' => PHP_URL_QUERY,
            'fragment' => PHP_URL_FRAGMENT
        ];
        $parsed_components = [];
        foreach ($acceptable_components as $component_name => $component) {
            if (($parsed_component = parse_url($url, $component)) !== false) {
                $parsed_components[$component_name] = $parsed_component;
                continue;
            }

            return false;
        }

        return $parsed_components;
    }

    /**
     * Create URL string from given components returned by toComponents.
     * @see toComponents
     *
     * @param array $components
     * @return string
     */
    public static function toUrlString(array $components)
    {
        $url = $components['scheme'] . '://';
        $url .= $components['host'];
        $url .= ($components['path'] == '/' ? '' : $components['path']);
        $url .= (!empty($components['query']) ? '?' . $components['query'] : '');
        $url .= (!empty($components['fragment']) ? '#' . $components['fragment'] : '');

        return $url;
    }

}
