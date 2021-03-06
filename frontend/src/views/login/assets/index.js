import Cookies from 'js-cookie'
import http from '@/utils/http'
import {validateAlpha} from '@/utils/validate'
import img_logo from '@/assets/images/logo.png'
import img_login_banner from '@/assets/images/login_banner.png'

export default {
    data() {
        return {
            img_logo: img_logo,
            img_login_banner: img_login_banner,
            loading: false,
            form: {
                name: '',
                password: '',
                seccode: ''
            },
            seccodeUrl: '',
            seccodeImg: window.BASE_API + '/admin/login/seccode',
            rules: {
                name: [
                    {
                        required: true,
                        message: __('请输入账号'),
                        trigger: 'blur'
                    }
                ],
                password: [
                    {
                        required: true,
                        message: __('请输入密码'),
                        trigger: 'blur'
                    }, {
                        min: 6,
                        max: 12,
                        message: __('长度在 %d 到 %d 个字符', 6, 12),
                        trigger: 'blur'
                    }
                ],
                seccode: [
                    {
                        required: true,
                        message: __('请输入验证码'),
                        trigger: 'blur'
                    }, {
                        min: 4,
                        max: 4,
                        message: __('长度为 %d 个字符', 4),
                        trigger: 'blur'
                    }, {
                        validator: validateAlpha,
                        trigger: 'blur'
                    }
                ]
            },
            checked: false,
            remember_me: 0
        }
    },
    methods: {
        refreshSeccode() {
            this.seccodeUrl = ''
            setTimeout(() => {
                this.seccodeUrl = this.seccodeImg + '?v=' + moment().unix()
            }, 300)
        },
        handleSubmit(form) {
            if (this.loading)
                return
            this.$refs.form.validate((valid) => {
                if (valid) {
                    this.loading = !this.loading
                    let data = {}
                    data.name = this.form.name
                    data.password = this.form.password
                    data.seccode = this.form.seccode
                    if (this.checked) {
                        data.remember_me = 1
                    } else {
                        data.remember_me = 0
                    }
                    this.apiPost('login/check', data).then((res) => {
                        _g.success(res.message)
                        this.refreshSeccode()
                        res.data.keepLogin = this.isKeepLogin()
                        this.$store.dispatch('login', res.data)
                        setTimeout(() => {
                            router.replace('/')
                        }, 1000)
                    },(res) => {
                        this.loading = !this.loading
                    })
                } else {
                    return false
                }
            })
        },
        checkIsLogin() {
            let data = {
                is_login: 'T'
            }
            this.apiPost('login/is_login', data).then((res) => {
                if (res.code == 200) {
                    router.replace('/')
                }
            })
        },
        keepLogin() {
            Cookies.set(
                'keep_login', this.checked
                ? 'T'
                : 'F', {expires: 30})
        },
        checkKeepLogin() {
            this.checked = this.isKeepLogin()
        },
        isKeepLogin() {
            return Cookies.get('keep_login') === 'T'
        }
    },
    created() {
        this.checkIsLogin()
        this.seccodeUrl = this.seccodeImg
        this.checkKeepLogin()
    },
    mounted() {
        window.addEventListener('keyup', (e) => {
            if (e.keyCode === 13) {
                this.handleSubmit('form')
            }
        })
    },
    mixins: [http]
}
