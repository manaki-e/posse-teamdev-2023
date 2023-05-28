<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SlackController;
use App\Models\Product;
use App\Models\ProductDealLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminItemController extends Controller
{
    public function __construct(SlackController $slackController)
    {
        $this->slackController = $slackController;
        $this->slackGlobalAnnouncementChannelId = $slackController->searchChannelId('peerperk全体お知らせ', false);
        $this->slackAdminChannelId = $slackController->searchChannelId('peerperk管理者', true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //登録済みアイテム一覧
        $japanese_product_statuses = Product::JAPANESE_STATUS;
        $not_pending_products = Product::approvedProducts()->with('user')->paginate(10, ['*'], 'not_pending')->appends(['pending' => request('pending')]);

        //登録申請対応待ちアイテム一覧
        $pending_products = Product::pendingProducts()->with('user')->paginate(5, ['*'], 'pending')->appends(['not_pending' => request('not_pending')]);

        return view('admin.items.index', compact('not_pending_products', 'pending_products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $item
     * @return \Illuminate\Http\Response
     */
    public function show($item)
    {
        $product = Product::with('user')->with('productImages')->with('request')->with('productTags.tag')->withCount('productLikes')->findOrFail($item);
        $product->japanese_status = Product::JAPANESE_STATUS[$product->status];

        $product_deals = ProductDealLog::with('user')->where('product_id', $item)->paginate(10);

        return view('admin.items.detail', compact('product', 'product_deals'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $item)
    {
        $product = Product::findOrFail($item);
        $product->point = $request->point;
        if ($product->status == 1) {
            $product->status = 2;
        }
        $product->save();
        //slack登録申請者
        $this->slackController->sendNotification($product->user->slackID, "管理者がポイントを設定し、あなたのアイテムを登録しました！");
        //slack管理者
        $this->slackController->sendNotification($this->slackAdminChannelId, "<@".$product->user->slackID.">の新たなアイテムを登録しました！");
        //全体チャンネル
        $this->slackController->sendNotification($this->slackGlobalAnnouncementChannelId, "<@".$product->user->slackID.">より、新たなアイテムが追加されました！");
        return Redirect::route('admin.items.index')->with(['flush.message' => 'アイテムのポイント設定が正しく行われました', 'flush.alert_type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($item)
    {
        $product = Product::findOrFail($item);
        if ($product->status == 3) {
            return Redirect::route('admin.items.index')->with(['flush.message' => '貸出中のアイテムは削除できません', 'flush.alert_type' => 'error']);
        }
        $product->delete();
        // アイテムテーブルに紐づく各テーブルのデータも削除する

        return Redirect::route('admin.items.index')->with(['flush.message' => 'アイテムが正しく削除されました', 'flush.alert_type' => 'success']);
    }
}
