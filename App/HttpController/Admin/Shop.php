<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/4
 * Time: 下午5:51
 *
 */

namespace App\HttpController\Admin;

use App\Utils\Code;
use ezswoole\Validate;

/**
 * 店铺
 * Class Shop
 * @package App\HttpController\Admin
 */
class Shop extends Admin
{
	/**
	 * 店铺基础信息设置
	 * @method POST
	 * @param  string $name
	 * @param  string $logo
	 * @param  string $contact_number
	 * @param  string $description
	 * @param  string $host
	 * @author CM
	 */
	public function setBaseInfo()
	{
		if( $this->validate( $this->post, 'Admin/Shop.setBaseInfo' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$data = [];
			if( isset( $this->post['logo'] ) ){
				$data['logo'] = $this->post['logo'];
			}
			if( isset( $this->post['name'] ) ){
				$data['name'] = $this->post['name'];
			}
			if( isset( $this->post['contact_number'] ) ){
				$data['contact_number'] = $this->post['contact_number'];
			}
			if( isset( $this->post['description'] ) ){
				$data['description'] = $this->post['description'];
			}
			if( isset( $this->post['host'] ) ){
				$data['host'] = $this->post['host'];
			}
			model( 'Shop' )->editShop( ['id' => 1], $data );
			$this->send( Code::success, [] );
		}
	}

    /**
     * 首页信息设置
     * @method POST
     * @param  string $top_desc
     * @param  string $ads_status
     * @param  string $ads_img
     * @param  string $ads_title
     * @param  string $ads_title_sec
     * @param  string $ads_body
     * @author CM
     */
    public function setIndexInfo()
    {
        if( $this->validate( $this->post, 'Admin/Shop.setBaseInfo' ) !== true ){
            $this->send( Code::param_error, [], $this->getValidate()->getError() );
        } else{
            $data = [];
            if( isset( $this->post['top_desc'] ) ){
                $data['top_desc'] = $this->post['top_desc'];
            }
            if( isset( $this->post['ads_status'] ) ){
                $data['ads_status'] = $this->post['ads_status'];
            }
            if( isset( $this->post['ads_img'] ) ){
                $data['ads_img'] = $this->post['ads_img'];
            }
            if( isset( $this->post['ads_title'] ) ){
                $data['ads_title'] = $this->post['ads_title'];
            }
            if( isset( $this->post['ads_title_sec'] ) ){
                $data['ads_title_sec'] = $this->post['ads_title_sec'];
            }
            if( isset( $this->post['ads_body'] ) ){
                $data['ads_body'] = $this->post['ads_body'];
            }
            model( 'Shop' )->editShop( ['id' => 1], $data );
            $this->send( Code::success, [$data['ads_body']] );
        }
    }

	/**
	 * 店铺配色方案设置
	 * @method POST
	 * @param  string $color_scheme
	 * @author CM
	 */
	public function setColorScheme()
	{
		if( $this->validate( $this->post, 'Admin/Shop.setColorScheme' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			model( 'Shop' )->editShop( ['id' => 1], ['color_scheme' => $this->post['color_scheme']] );
			$this->send( Code::success, [] );
		}
	}

	/**
	 * 店铺首页模板选择【废弃】
	 * @method POST
	 * @param  int $portal_template_id
	 * @author CM
	 */
	public function setPortalTemplate()
	{
		if( $this->validate( $this->post, 'Admin/Shop.setPortalTemplate' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			model( 'Shop' )->editShop( ['id' => 1], ['portal_template_id' => $this->post['portal_template_id']] );
			$this->send( Code::success, [] );
		}
	}

	/**
	 * 店铺信息
	 * @method GET
	 * @author CM
	 */
	public function info()
	{
		$shop     = model( 'Shop' )->getShopInfo( ['id' => 1] );
		$validate = new Validate();
		if( $validate->is( $shop['host'], 'url' ) === true ){
			$shop['portal_url'] = rtrim( $shop['host'], '/' )."/mobile";
		} else{
			$shop['portal_url'] = $this->request->domain()."/mobile";
		}
		return $this->send( Code::success, ['info' => $shop] );
	}

	/**
	 * 店铺分类页风格设置
	 * @method POST
	 * @param  int $goods_category_style
	 * @author CM
	 */
	public function setGoodsCategoryStyle()
	{
		if( $this->validate( $this->post, 'Admin/Shop.setGoodsCategoryStyle' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			model( 'Shop' )->editShop( ['id' => 1], ['goods_category_style' => $this->post['goods_category_style']] );
			$this->send( Code::success );
		}
	}

	/**
	 * 设置订单相关过期时间
	 * @method POST
	 * @param int $order_auto_close_expires         待付款订单N秒后自动关闭订单，默认604800秒
	 * @param int $order_auto_confirm_expires       已发货订单后自动确认收货，默认604800秒
	 * @param int $order_auto_close_refound_expires 已收货订单后关闭退款／退货功能，0代表确认收货后无法维权，默认0秒
	 * @author CM
	 */
	public function setOrderExpires()
	{
		if( $this->validate( $this->post, 'Admin/Shop.setOrderExpires' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			model( 'Shop' )->editShop( ['id' => 1], [
				'order_auto_close_expires'         => $this->post['order_auto_close_expires'],
				'order_auto_confirm_expires'       => $this->post['order_auto_confirm_expires'],
				'order_auto_close_refound_expires' => $this->post['order_auto_close_refound_expires'],
			] );
			$this->send( Code::success );
		}
	}
}