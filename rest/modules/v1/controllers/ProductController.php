<?php
/**
 * Created by PhpStorm.
 * User: Jiang Haiqiang
 * Date: 2020/7/23
 * Time: 3:02 PM
 */
namespace rest\modules\v1\controllers;

use roach\extensions\EFilter;
use roach\rest\Response;

/**
 * Class IndexController
 * @package www\modules\v1\controllers
 * @datetime 2020/7/23 3:02 PM
 * @author roach
 * @email jhq0113@163.com
 */
class ProductController extends Controller
{
    /**GET-分页获取商品列表
     * @return array
     * @datetime 2020/7/25 7:23 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function indexAction()
    {
        $page     = EFilter::fInt('page', $_GET);
        $pageSize = EFilter::fInt('pageSize', $_GET);
        //默认从1开始
        $page     = $page < 1 ? 1 : $page;

        //页大小最小为1
        $pageSize = $pageSize < 1 ? 1 : $pageSize;
        //页大小最大为1000
        $pageSize = $pageSize > 1000 ? 1000 : $pageSize;

        //仅为了测试使用
        $empty = (time()/2 === 0);
        if($empty) {
            return $this->response(Response::HTTP_EMPTY, '产品列表为空');
        }

        return [
            'data' => [
                'page'      => $page,
                'pageSize'  => $pageSize,
                'list'      => [
                    [
                        'id'    => 1,
                        'name'  => 'roach',
                        'skuList' => [
                            [
                                'id'    => 113,
                                'name'  => 'roach-rest'
                            ],
                            [
                                'id'    => 114,
                                'name'  => 'roach-orm'
                            ],
                        ]
                    ],
                    [
                        'id'    => 2,
                        'name'  => 'roach-rest-app',
                        'skuList' => [
                            [
                                'id'    => 115,
                                'name'  => 'roach'
                            ]
                        ]
                    ],
                ]
            ]
        ];
    }

    /**GET-查看商品详情
     * @return array
     * @datetime 2020/7/25 7:26 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function infoAction()
    {
        $id = EFilter::fInt('id', $_GET);
        if($id < 1) {
            return $this->response(Response::HTTP_NOT_FOUND, '不存在id:{id}的商品', [
                'id' => $id
            ]);
        }

        //仅为了测试使用
        $empty = (time()/2 === 0);
        if($empty) {
            return $this->response(Response::HTTP_NOT_FOUND, '不存在id:{id}的商品', [
                'id' => $id
            ]);
        }

        return [
            'data' => [
                'id'        => $id,
                'name'      => 'roach',
                'timestamp' => time()
            ]
        ];
    }

    /**POST-添加商品
     * @datetime 2020/7/25 7:29 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function createAction()
    {
        $name = EFilter::fStr('name', $_POST);
        if(empty($name)) {
            return $this->response(Response::HTTP_BAD_REQUEST, '商品名称不能为空');
        }

        return $this->response(Response::HTTP_CREATED, '商品添加成功');
    }

    /**PUT-更新产品
     * @return array
     * @datetime 2020/7/25 7:43 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function updateAction()
    {
        $id = EFilter::fInt('id', $_GET);
        if($id < 1) {
            return $this->response(Response::HTTP_NOT_FOUND, '不存在id:{id}的商品', [
                'id' => $id
            ]);
        }

        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        if(!isset($data['name'])) {
            return $this->response(Response::HTTP_BAD_REQUEST, '商品名称不能为空');
        }

        return [
            'data' => [
                'id'        => $id,
                'name'      => $data['name'],
                'timestamp' => time()
            ]
        ];
    }

    /**DELETE-删除商品
     * @return array
     * @datetime 2020/7/25 7:45 PM
     * @author roach
     * @email jhq0113@163.com
     */
    public function deleteAction()
    {
        $id = EFilter::fInt('id', $_GET);
        if($id < 1) {
            return $this->response(Response::HTTP_NOT_FOUND, '不存在id:{id}的商品', [
                'id' => $id
            ]);
        }

        return $this->response(Response::HTTP_EMPTY, 'id:{id}的商品已删除', [
           'id' => $id
        ]);
    }
}