<?php

namespace Faker\Provider\ar_JO;

class Company extends \Faker\Provider\Company
{
    protected static $formats = array(
        '{{lastName}} {{companySuffix}}',
        '{{companyPrefix}} {{lastName}} {{companySuffix}}',
        '{{companyPrefix}} {{lastName}}',
    );

    protected static $catchPhraseWords = array(
        array('الخدمات','الحلول','الانظمة'),
        array(
            'الذهبية','الذكية','المتطورة','المتقدمة', 'الدولية', 'المتخصصه', 'السريعة',
            'المثلى', 'الابداعية', 'المتكاملة', 'المتغيرة', 'المثالية'
            ),
    );

    protected static $bsWords = array(
        array(
            'تصميم', 'برمجة', 'حساب', 'تسويق', 'اعلانية', 'هيئة', 'مباشرة', 'مجال', 'حماية', 'دولي', 'مشاركة', 'إنتاج'
        ),
        array(
            'دعم القرار', 'حرية رأي', 'منافسة', 'مشاركة', 'عهد', 'دولة', 'قرية', 'جمعية', 'حقوق'),
        array(
            'مسافر', 'تشغيل', 'زهرة', 'مبنى', 'تجميع', 'مشاطرة', 'مزايدة', 'مزرعة', 'واسعة')
    );
    protected static $companyPrefix = array('شركة','مؤسسة','مجموعة','مكتب','أكاديمية','معرض');

    protected static $companySuffix = array('وأولاده', 'للمساهمة المحدودة', ' ذ.م.م', 'مساهمة عامة', 'وشركائه');

    /**
     * @example 'مؤسسة'
     * @return string
     */
    public function companyPrefix()
    {
        return static::randomElement(self::$companyPrefix);
    }

    /**
     * @example 'Robust full-range hub'
     */
    public function catchPhrase()
    {
        $result = array();
        foreach (static::$catchPhraseWords as &$word) {
            $result[] = static::randomElement($word);
        }

        return join($result, ' ');
    }

    /**
     * @example 'integrate extensible convergence'
     */
    public function bs()
    {
        $result = array();
        foreach (static::$bsWords as &$word) {
            $result[] = static::randomElement($word);
        }

        return join($result, ' ');
    }
}
