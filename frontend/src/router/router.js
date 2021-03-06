// in development env not use Lazy Loading,because Lazy Loading too many pages will cause webpack hot update too slow.so only in production use Lazy Loading
const importRouter = require('./import_' + process.env.NODE_ENV)
import '@/i18n'
import layout from '../views/layout/layout'
import routerMenu from './menu'

// 不作为 layout 组件的子页面展示的页面单
export const commonRouter = [
    {
        path: '/login',
        name: 'login',
        meta: {
            title: __('登录')
        },
        component: importRouter('login/index')
    }, {
        path: '/locking',
        name: 'locking',
        meta: {
            title: __('系统已锁定')
        },
        component: importRouter('layout/lockscreen/components/locking-page')
    }, {
        path: '/403',
        name: '403',
        meta: {
            title: '403 ' + __('权限不足')
        },
        component: importRouter('error-page/403')
    }, {
        path: '/404',
        name: '404',
        meta: {
            title: '404 ' + __('页面不存在')
        },
        component: importRouter('error-page/404')
    }, {
        path: '/500',
        name: '500',
        meta: {
            title: '500 ' + __('服务端错误')
        },
        component: importRouter('error-page/500')
    }
]

// 作为 layout 组件的子页面展示但是不在左侧菜单显示的路由写在 otherRouter 里
export const otherRouter = {
    path: '/',
    component: layout,
    redirect: '/dashboard',
    name: 'otherRouter',
    children: [
        {
            path: 'dashboard',
            meta: {
                title: __('首页')
            },
            name: 'dashboard',
            icon: 'ios-home-outline',
            component: importRouter('dashboard/index')
        }, {
            meta: {
                title: __('刷新页面')
            },
            path: 'refresh',
            component: importRouter('layout/refresh'),
            name: 'refresh'
        }, {
            path: 'message',
            meta: {
                title: __('消息中心')
            },
            name: 'message_index',
            component: importRouter('message/message')
        }
    ]
}

let appRouterData = [
    {
        path: '/option',
        icon: 'ios-gear',
        name: 'option',
        meta: {
            title: __('基础设置')
        },
        component: layout,
        children: [
            {
                path: 'menu',
                icon: '',
                name: 'menu_index',
                meta: {
                    title: __('菜单管理')
                },
                component: importRouter('menu/index')
            },
            {
                path: 'position_category',
                icon: '',
                name: 'position_category_index',
                meta: {
                    title: __('职位分类')
                },
                component: importRouter('position_category/index')
            },
            {
                path: 'structure',
                icon: '',
                name: 'structure_index',
                meta: {
                    title: __('组织管理')
                },
                component: importRouter('structure/index')
            }
        ]
    }
]


let dataMenu = localStorage.getItem('menus')
dataMenu = dataMenu ? JSON.parse(dataMenu) : []

if (dataMenu){
  let routes = []
  //routerMenu(routes,dataMenu)
  //appRouterData = appRouterData.concat(routes)
}

export const appRouter = appRouterData

// 作为 layout 组件的子页面展示并且在左侧菜单显示的路由写在 appRouter 里
//export appRouter appRouter

// 所有上面定义的路由都要写在下面的 routers 里
export const routers = [
    ...commonRouter,
    otherRouter,
    ...appRouter
]
