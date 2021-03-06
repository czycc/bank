<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
    <meta content="telephone=no" name="format-detection"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta http-equiv="pragma" content="no-cache"/>
    <title>becks</title>
    <link rel="stylesheet" href="css/vant.css">
    <link rel="stylesheet" href="css/comman.css">
    <link rel="stylesheet" href="css/index.css">
    <script type="text/javascript" src="js/vue.min.js"></script>
    <script type="text/javascript" src="js/font_rem.js"></script>
    <script type="text/javascript" src="js/vant.min.js"></script>
    <script type="text/javascript" src="js/shake.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
</head>
<body>
<div id="app" v-cloak class="container">
    <!-- 开始页 -->
    <div class="index flex-column flex-center align-items" v-if="panel == 0">
        <div class="logo">
            <img src="./image/logo.png" alt="">
        </div>
        <div class="ready-go" @click="toShake">
            <img src="./image/go.png" alt="">
        </div>
    </div>

    <!-- 摇一摇 -->
    <div class="shake flex-column flex-center align-items" v-if="panel == 1">
        <div class="shake-icon animate__swing animate__infinite" :class="shaked ? 'animate__animated' : ''">
            <img src="./image/shake.png" alt="">
        </div>
        <div class="shake-txt">
            <img src="./image/shake_txt.png" alt="">
        </div>
    </div>

    <!-- 排名页 -->
    <div class="rank" v-if="panel == 2">
        <div class="flex-column flex-center align-items rank-wrepper">
            <div class="rank-txt">
                <img src="image/rank_txt.png">
            </div>
            <div class="rank1 mt112">
                <img class="img-border" src="image/rank_border.png" alt="">
                <img class="rank-icon" src="image/rank1.png" alt="">
                <img class="img-avatar" id="top1" v-bind:src="top1" alt="">
            </div>
            <div class="flex mt60">
                <div class="rank2">
                    <img class="img-border" src="image/rank_border.png" alt="">
                    <img class="rank-icon" src="image/rank2.png" alt="">
                    <img class="img-avatar" id="top2" v-bind:src="top2" alt="">
                </div>
                <div class="rank2 ml80">
                    <img class="img-border" src="image/rank_border.png" alt="">
                    <img class="rank-icon" src="image/rank3.png" alt="">
                    <img class="img-avatar" id="top3" v-bind:src="top3" alt="">
                </div>
            </div>
            <img class="logo" src="./image/logo_rank.png" alt="">
            <img class="thanks" src="image/thanks.png" alt="">
        </div>

        <img src="image/beer.png" class="beer">
    </div>
</div>
<script type="text/javascript">
    new Vue({
        el: '#app',
        data: {
            socket: null,
            panel: 0,
            shaked: false,
            timer: null,
            waitTime: 15, // 15 * 100ms
            count: 0,
            isEnd: false,
            awaitingTimer: null,
            top1:null,
            top2:null,
            top3:null

        },
        methods: {
            shakeEventDidOccur() {
                let sendtime = 500
                if (this.isEnd) { // 结束
                    return
                }
                this.count++
                if (this.awaitingTimer == null) {
                    this.awaitingTimer = setTimeout(() => {
                        this.sendShake()
                        this.count = 0
                        this.awaitingTimer = null
                    }, sendtime)
                }


                this.shaked = true
                this.waitTime = 15
                if (!this.timer) {
                    this.timer = setInterval(() => {
                        this.waitTime--
                        if (this.waitTime == 0) {
                            this.shaked = false
                            clearInterval(this.timer)
                            this.timer = null
                        }
                    }, 100)
                }
            },
            sendUser() {
                //发送用户进入事件
            },
            sendShake() {
                //发送摇一摇,统计一秒内摇多少次
                console.log("shake count :", this.count)
                this.socket.emit('becks_shake', `{"openid":"{{ $user->id }}", "shake":${this.count}}`);
            },
            toShake() {
                this.panel = 1
                this.socket.emit('becks_user_in', `{"openid":"{{ $user->id }}","avatar":"{{ $user->avatar }}","nickname":"{{ $user->name }}"}`);
                var myShakeEvent = new Shake({
                    threshold: 15, // optional shake strength threshold
                    timeout: 10 // optional, determines the frequency of event generation
                });
                myShakeEvent.start();
                if (typeof DeviceMotionEvent.requestPermission === 'function') {
                    DeviceMotionEvent.requestPermission()
                        .then(permissionState => {
                            if (permissionState === 'granted') {
                                window.addEventListener('devicemotion', () => {});
                            }
                        })
                        .catch(console.error);
                } else {
                    // handle regular non iOS 13+ devices
                }
                window.addEventListener('shake', this.shakeEventDidOccur, false);
            }
        },
        created() {
        },
        mounted() {
            // 监听
            this.socket = io("wss://api.shanghaichujie.com", {path: "/socket/socket.io"});

            this.socket.on('becks_rank', (data) => {
                //监听游戏结束,显示排行榜,json数组,4个排行,openid,avatar,nickname,rank
                this.isEnd = true
                this.panel = 2
                this.top1 = data[0].avatar
                this.top2 = data[1].avatar
                this.top3 = data[2].avatar

            });
        }
    });
</script>
</body>
</html>
