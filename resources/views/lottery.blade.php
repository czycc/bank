<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">
		<meta content="telephone=no" name="format-detection" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta http-equiv="pragma" content="no-cache" />
		<title>becks</title>
		<link rel="stylesheet" href="css/vant.css">
		<link rel="stylesheet" href="css/comman.css">
		<link rel="stylesheet" href="css/lottery1.css">
		<script type="text/javascript" src="js/vue.min.js"></script>
		<script type="text/javascript" src="js/font_rem.js"></script>
		<script type="text/javascript" src="js/vant.min.js"></script>
	</head>
	<body>
    <audio id="bgMusic">
        <source  src="https://h5-touch.oss-cn-shanghai.aliyuncs.com/MP3/%E8%BD%AE%E7%9B%98%E8%BD%AC%E5%8A%A8.mp3" type="audio/mp3">
    </audio>
		<div id="app" v-cloak class="container">
			<div class="lottery flex-column flex-center align-items">
				<div class="lottery-container">
					<div class="align-items">
						<div class="lottery-item lottery-item1" :class="[isEnd && active == 1 ? 'animate__flash animate__animated' : '',active == 1 ? 'active' : '']"></div>
						<div class="lottery-item lottery-item2 ml60" :class="[isEnd && active == 2 ? 'animate__flash animate__animated' : '',active == 2 ? 'active' : '']"></div>
						<div class="lottery-item lottery-item3 ml60" :class="[isEnd && active == 3 ? 'animate__flash animate__animated' : '',active == 3 ? 'active' : '']"></div>
					</div>
					<div class="align-items mt30">
						<div class="lottery-item lottery-item8" :class="[isEnd && active == 8 ? 'animate__flash animate__animated' : '',active == 8 ? 'active' : '']"></div>
						<div class="beer ml80" @click="startLottry"></div>
						<div class="lottery-item lottery-item4 ml80" :class="[isEnd && active == 4 ? 'animate__flash animate__animated' : '',active == 4 ? 'active' : '']"></div>
					</div>
					<div class="align-items mt30">
						<div class="lottery-item lottery-item7" :class="[isEnd && active == 7 ? 'animate__flash animate__animated' : '',active == 7 ? 'active' : '']"></div>
						<div class="lottery-item lottery-item6 ml60" :class="[isEnd && active == 6 ? 'animate__flash animate__animated' : '',active == 6 ? 'active' : '']"></div>
						<div class="lottery-item lottery-item5 ml60" :class="[isEnd && active == 5 ? 'animate__flash animate__animated' : '',active == 5 ? 'active' : '']"></div>
					</div>
				</div>
				<img class="logo" src="./image/logo_rank.png" alt="">
			</div>
			<!-- 弹框 -->
			<div class="modal-scale flex-column flex-center align-items" :class="show ? 'show' : '' ">
				<div class="dialog-container" :class="valuable ? 'valuable' :''">
					<div class="close" @click="close">
						<img src="image/close.png" alt="">
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			function getRandomNumberByRange(start, end) {
				return Math.floor(Math.random() * (end - start) + start)
			}

			new Vue({
				el: '#app',
				data: {
					active: 0,
					show: false,
					interval: null,
					isEnd: false,
					valuable: false,
					awardIdx: {{ $item }} // 左上角为1 瞬时针增加
				},
				methods: {
					startLottry() {
						if (this.interval || this.isEnd) return
						let timer = 8000 + this.awardIdx*500  //getRandomNumberByRange(6000, 10000)
                        let audio = document.getElementById('bgMusic')
						this.interval = setInterval(() => {
							if (this.active == 8) {
								this.active = 1
							} else {
								this.active++
							}
                            audio.play()
                        }, 500)
						setTimeout(() => {
							this.stopLottry()
                            audio.pause()
						}, timer)
					},
					stopLottry() {
						if (this.interval) {
							clearInterval(this.interval)
							this.interval = null
						}
						this.isEnd = true
						if (this.active == 4 || this.active == 7) { // 4 或者 7 盾牌
							// 设置奖品为盾牌
							this.valuable = true
						}
						setTimeout(() => {
							this.show = true
						}, 1500)

					},
					close() {
						// this.show = false
					}
				},
				created() {


				},
				mounted() {

				}
			});
		</script>
	</body>
</html>
