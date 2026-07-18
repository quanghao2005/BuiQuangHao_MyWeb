<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Illuminate\Support\Str;
use App\Models\User;

class GeneratePostsSeeder extends Seeder
{
    public function run()
    {
        $userId = User::first()->id ?? 1;

        $posts = [
            [
                'title' => 'Đánh giá iPhone 15 Pro Max sau 3 tháng sử dụng: Có đáng đồng tiền?',
                'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?q=80&w=800&auto=format&fit=crop',
                'content' => '
                    <p><b>iPhone 15 Pro Max</b> là chiếc điện thoại cao cấp nhất của Apple tính đến thời điểm hiện tại. Sau 3 tháng sử dụng, dưới đây là những đánh giá chi tiết về siêu phẩm này.</p>
                    <h3>1. Thiết kế Titanium sang trọng và siêu nhẹ</h3>
                    <p>Một trong những điểm ấn tượng nhất là viền Titanium. Cảm giác cầm nắm nhẹ hơn đáng kể so với viền thép không gỉ trên thế hệ trước. Các góc cạnh được bo cong nhẹ giúp máy không bị cấn tay khi sử dụng lâu.</p>
                    <h3>2. Cổng sạc USB-C: Sự thay đổi mong đợi</h3>
                    <p>Apple cuối cùng cũng chuyển sang cổng <strong>USB-C</strong>, giúp người dùng có thể dùng chung một sợi cáp sạc cho cả MacBook, iPad và iPhone. Tốc độ truyền dữ liệu cũng tăng vọt với chuẩn USB 3.0.</p>
                    <h3>3. Camera zoom quang 5x ấn tượng</h3>
                    <p>Khả năng zoom quang học lên đến 5x giúp chụp các chi tiết ở xa một cách sắc nét. Ảnh chân dung (Portrait) được cải tiến rất nhiều, cho phép điều chỉnh tiêu cự sau khi chụp.</p>
                    <p><i>Kết luận:</i> Nếu bạn đang tìm kiếm một chiếc điện thoại bền bỉ, camera xuất sắc và hiệu năng mạnh mẽ, iPhone 15 Pro Max hoàn toàn xứng đáng với mức giá.</p>
                ',
                'type' => 'Đánh giá'
            ],
            [
                'title' => 'Top 5 điện thoại chơi game tốt nhất năm 2024 không thể bỏ qua',
                'image' => 'https://images.unsplash.com/photo-1598327105666-5b89351cb315?q=80&w=800&auto=format&fit=crop',
                'content' => '
                    <p>Thị trường <b>smartphone gaming</b> năm 2024 đang trở nên cực kỳ sôi động. Dưới đây là 5 mẫu điện thoại chiến game mượt mà nhất mà bạn nên cân nhắc.</p>
                    <ul>
                        <li><b style="color:red">ASUS ROG Phone 8 Pro:</b> Quái vật cấu hình với chip Snapdragon 8 Gen 3, RAM lên đến 24GB và hệ thống tản nhiệt tối tân.</li>
                        <li><b style="color:red">RedMagic 9 Pro:</b> Thiết kế hầm hố, pin 6500mAh cực trâu, đi kèm quạt tản nhiệt tích hợp siêu mát mẻ.</li>
                        <li><b style="color:red">iPhone 15 Pro Max:</b> Nhờ con chip A17 Pro mạnh mẽ, iPhone giờ đây có thể chơi được cả những tựa game AAA cấu hình cao.</li>
                        <li><b style="color:red">Samsung Galaxy S24 Ultra:</b> Màn hình hiển thị xuất sắc, tần số quét 120Hz và bút S Pen hỗ trợ chơi game rất tốt.</li>
                        <li><b style="color:red">Xiaomi 14 Pro:</b> Lựa chọn giá tốt hơn với chip Snapdragon 8 Gen 3, tối ưu cực kỳ mượt mà.</li>
                    </ul>
                    <p>Đừng quên chọn một chiếc máy có tản nhiệt tốt để tránh tình trạng tụt FPS khi chơi game trong thời gian dài nhé!</p>
                ',
                'type' => 'Top list'
            ],
            [
                'title' => 'Hướng dẫn tiết kiệm pin cho smartphone Android và iOS hiệu quả',
                'image' => 'https://images.unsplash.com/photo-1585338107529-13afc5f02586?q=80&w=800&auto=format&fit=crop',
                'content' => '
                    <p>Dù điện thoại của bạn có pin khủng đến đâu thì việc sử dụng không đúng cách cũng khiến máy nhanh hết pin. Hãy áp dụng ngay các mẹo dưới đây!</p>
                    <h3>Đối với người dùng iPhone (iOS)</h3>
                    <ul>
                        <li><b>Tắt làm mới ứng dụng trong nền:</b> Vào Cài đặt > Cài đặt chung > Làm mới ứng dụng trong nền và tắt các ứng dụng không cần thiết.</li>
                        <li><b>Tắt dịch vụ định vị:</b> Vô hiệu hóa tính năng theo dõi vị trí với các ứng dụng hiếm khi dùng.</li>
                        <li><b>Bật chế độ nguồn điện thấp:</b> Giúp giảm thiểu các hiệu ứng hình ảnh và tải nền để kéo dài thời lượng pin.</li>
                    </ul>
                    <h3>Đối với người dùng Android</h3>
                    <ul>
                        <li><b>Sử dụng màn hình tối (Dark Mode):</b> Rất hữu ích đối với các máy dùng màn hình OLED/AMOLED.</li>
                        <li><b>Tắt Always-On Display (AOD):</b> Tính năng hiển thị đồng hồ liên tục này ngốn khoảng 1% pin mỗi giờ.</li>
                        <li><b>Xóa bộ nhớ đệm (Cache) định kỳ:</b> Giúp thiết bị chạy nhẹ nhàng và ít tiêu thụ năng lượng hơn.</li>
                    </ul>
                    <p>Chúc bạn có trải nghiệm sử dụng điện thoại bền bỉ cả ngày dài!</p>
                ',
                'type' => 'Thủ thuật'
            ],
            [
                'title' => 'So sánh Samsung Galaxy S24 Ultra và iPhone 15 Pro Max: Cuộc chiến ngôi vương',
                'image' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?q=80&w=800&auto=format&fit=crop',
                'content' => '
                    <p>Đây là hai siêu phẩm đại diện cho hai thế giới Android và iOS. Vậy đâu là chiếc máy phù hợp với bạn?</p>
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Tiêu chí</th>
                                <th>Galaxy S24 Ultra</th>
                                <th>iPhone 15 Pro Max</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><b>Thiết kế</b></td>
                                <td>Khung Titan, thiết kế vuông vức, có bút S Pen</td>
                                <td>Khung Titan, viền bo tròn nhẹ, cổng USB-C</td>
                            </tr>
                            <tr>
                                <td><b>Màn hình</b></td>
                                <td>6.8 inch, chống lóa tốt, 2600 nits</td>
                                <td>6.7 inch, Super Retina XDR, 2000 nits</td>
                            </tr>
                            <tr>
                                <td><b>Camera</b></td>
                                <td>200MP, Zoom quang 5x & 3x</td>
                                <td>48MP, Zoom quang 5x</td>
                            </tr>
                            <tr>
                                <td><b>Hiệu năng</b></td>
                                <td>Snapdragon 8 Gen 3 for Galaxy</td>
                                <td>Apple A17 Pro (3nm)</td>
                            </tr>
                        </tbody>
                    </table>
                    <p><i>Đánh giá chung:</i> Nếu bạn thích sự tự do, đa nhiệm tốt và bút S-Pen, <b>S24 Ultra</b> là sự lựa chọn số 1. Ngược lại, nếu bạn muốn một hệ sinh thái đồng bộ, camera quay phim đỉnh cao, hãy chọn <b>iPhone 15 Pro Max</b>.</p>
                ',
                'type' => 'So sánh'
            ],
            [
                'title' => 'Bí quyết chọn mua laptop sinh viên giá rẻ, cấu hình mạnh năm nay',
                'image' => 'https://images.unsplash.com/photo-1531297172868-6cb2850c99f4?q=80&w=800&auto=format&fit=crop',
                'content' => '
                    <p>Mùa tựu trường đến gần, việc chọn một chiếc <b>laptop</b> vừa túi tiền nhưng vẫn đáp ứng tốt việc học tập là điều nhiều bạn sinh viên quan tâm.</p>
                    <h3>1. Chọn CPU phù hợp</h3>
                    <p>Không nhất thiết phải mua Core i7 hay Ryzen 7 đắt đỏ. Các dòng chip <b>Intel Core i5 (thế hệ 12, 13)</b> hoặc <b>AMD Ryzen 5</b> là quá đủ để chạy Word, Excel và các phần mềm đồ họa nhẹ.</p>
                    <h3>2. RAM tối thiểu 8GB (Khuyên dùng 16GB)</h3>
                    <p>Với nhu cầu mở nhiều tab Chrome cùng lúc, 8GB RAM là con số tối thiểu. Nếu dư dả, hãy nâng cấp lên 16GB để máy luôn chạy mượt mà trong 4 năm đại học.</p>
                    <h3>3. Ổ cứng SSD 512GB</h3>
                    <p>Đừng mua ổ HDD nữa. Hãy chọn ổ <b>SSD M.2 NVMe</b> từ 512GB trở lên để tốc độ khởi động Windows và ứng dụng nhanh như chớp.</p>
                    <h3>4. Trọng lượng và màn hình</h3>
                    <p>Nên chọn máy có màn hình <b>14 inch</b> viền mỏng và trọng lượng dưới <b>1.5 kg</b> để dễ dàng mang theo lên giảng đường hàng ngày.</p>
                    <p>Ghé thăm <b>Mobitech</b> ngay hôm nay để nhận ưu đãi giảm giá lên đến 20% khi mua laptop sinh viên!</p>
                ',
                'type' => 'Tư vấn'
            ],
        ];

        foreach ($posts as $postData) {
            Post::create([
                'title' => $postData['title'],
                'slug' => Str::slug($postData['title']),
                'content' => $postData['content'],
                'image' => $postData['image'],
                'status' => 1,
                'user_id' => $userId,
            ]);
        }
    }
}
