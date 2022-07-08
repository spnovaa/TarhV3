<?php


namespace App\HelperClasses\General;

use App\Setting;

/**
 * Class SettingsHandler
 * @package App\HelperClasses\General
 */
class SettingsHandler
{
    /**
     * @var
     */
    private $settings_complete;

    /**
     * SettingsHandler constructor.
     */
    public function __construct()
    {
        $this->settings_complete = Setting::first();
    }


//    ------------------------------------------------------------------------------------------------------------------
//    -------------------------------------------Getters And Setters----------------------------------------------------
//    ------------------------------------------------------------------------------------------------------------------

    /**
     * @return mixed
     */
    public function getSettingsComplete()
    {
        return $this->settings_complete;
    }

    /**
     * @param mixed $settings_complete
     */
    public function setSettingsComplete($settings_complete): void
    {
        $this->settings_complete = $settings_complete;
    }

    /**
     * @return mixed
     */
    public function getSafirTarhName()
    {
        return $this->settings_complete->safir_tarh_name;
    }

    /**
     * @return mixed
     */
    public function getShopTarhName()
    {
        return $this->settings_complete->shop_tarh_name;
    }

    /**
     * @return mixed
     */
    public function getDistributorTarhName()
    {
        return $this->settings_complete->dist_tarh_name;
    }

    /**
     * @return mixed
     */
    public function getGeneralTarhName()
    {
        return $this->settings_complete->tarh_name;
    }

    /**
     * @return mixed
     */
    public function getShopActive()
    {
        return $this->settings_complete->shop_active;
    }

    /**
     * @return mixed
     */
    public function getSafirActive()
    {
        return $this->settings_complete->safir_active;
    }

    /**
     * @return mixed
     */
    public function getDistActive()
    {
        return $this->settings_complete->dist_active;
    }

    /**
     * @return mixed
     */
    public function getCanShopAddNewBook()
    {
        return $this->settings_complete->can_shop_add_book;
    }

    /**
     * @return mixed
     */
    public function getCustomerPercentageLimit()
    {
        return $this->settings_complete->customer_percentage_limit_setting;
    }

    /**
     * @return mixed
     */
    public function getCustomerPercentageSetting()
    {
        return $this->settings_complete->customer_percentage_setting;
    }

    /**
     * @return mixed
     */
    public function getCustomerBuyCountLimit()
    {
        return $this->settings_complete->customer_buy_count_limit;
    }

    /**
     * @return mixed
     */
    public function getCustomerBuyCountPerBook()
    {
        return $this->settings_complete->customer_buy_count_limit_per_book;
    }

}
