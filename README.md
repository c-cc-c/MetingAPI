# MetingAPI 使用说明
项目基于meting.php，通过URL参数获取歌曲、播放列表、封面、歌词等音乐资源，示例链接自动适配当前服务器IP。

## 必选参数
|  参数名  |  作用  |  可选值  | 示例值 |
|  ----  | ----  |  ----  | ----  |
| type  | 指定请求的资源类型 |  指定请求的资源类型	song（歌曲）、playlist（播放列表）、url（播放地址）、pic（封面）、lrc（歌词）|	song |
| id  | 资源唯一ID（与type对应）|	数字/字符串（需与数据源匹配）|	1937066506（歌曲ID）、914645439（播放列表ID）

## 可选参数（不填用默认值）
| 参数名|	作用	|默认值	|可选值|
|  ----  | ----  |  ----  | ----  |
|server |	选择音乐数据源	|netease（网易云音乐）|	netease（网易云）、tencent（QQ音乐）、kuwo（酷我音乐）|

## 常用请求示例
获取单首歌曲信息（含播放地址/封面）
http://192.168.2.2/meting/?server=netease&type=song&id=1937066506

获取播放列表所有歌曲
http://192.168.2.2/meting/?server=netease&type=playlist&id=914645439

单独获取歌曲播放地址
http://192.168.2.2/meting/?server=netease&type=url&id=1937066506
