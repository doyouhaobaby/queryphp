<template>
<div ref="scrollCon" @DOMMouseScroll="handlescroll" @mousewheel="handlescroll" class="tags-outer-scroll-con">
    <div ref="leftmoveTagCon" class="leftmove-tag-con">
        <Dropdown transfer @on-click="handleTagsOption">
            <Button size="small" type="primary" @click="seeLeftTag()">
                <Icon type="android-more-vertical" :size="22"></Icon>
            </button>
            <DropdownMenu slot="list">
                <DropdownItem name="refreshTag">
                    <Icon type="refresh" :size="22"></Icon>
                </DropdownItem>
                <DropdownItem name="clearTag">{{__('关闭标签')}}</DropdownItem>
                <DropdownItem name="clearOthers">{{__('关闭其他')}}</DropdownItem>
                <DropdownItem name="clearRights">{{__('关闭右侧')}}</DropdownItem>
                <DropdownItem name="clearLefts">{{__('关闭左侧')}}</DropdownItem>
                <DropdownItem name="clearAll">{{__('关闭所有')}}</DropdownItem>
            </DropdownMenu>
        </Dropdown>
    </div>
    <div ref="closeAllTagCon" class="close-all-tag-con">
        <Dropdown transfer @on-click="handleTagsOption">
            <Button size="small" type="primary" @click="seeRightTag()">
                <Icon type="android-more-vertical" :size="22"></Icon>
            </Button>
            <DropdownMenu slot="list">
                <DropdownItem name="refreshTag">
                    <Icon type="refresh" :size="22"></Icon>
                </DropdownItem>
                <DropdownItem name="clearTag">{{__('关闭标签')}}</DropdownItem>
                <DropdownItem name="clearOthers">{{__('关闭其他')}}</DropdownItem>
                <DropdownItem name="clearRights">{{__('关闭右侧')}}</DropdownItem>
                <DropdownItem name="clearLefts">{{__('关闭左侧')}}</DropdownItem>
                <DropdownItem name="clearAll">{{__('关闭所有')}}</DropdownItem>
            </DropdownMenu>
        </Dropdown>
    </div>
    <div ref="tagDashboardCon" class="tag-dashboard">
        <Tag type="dot" @click.native="linkTo(pageOpenedDashboard)" :color="pageOpenedDashboard.name===currentPageName?'blue':'default'">
            <Tooltip :content="itemTitle(pageOpenedDashboard)" placement="bottom">
                {{ itemTitle(pageOpenedDashboard) }}
            </Tooltip>
        </Tag>
    </div>
    <div ref="scrollBody" class="tags-inner-scroll-body" :style="{left: tagBodyLeft + 'px'}">
        <draggable v-model="pageTagsLists">
            <transition-group name="taglist-moving-animation">
                <Tag type="dot" v-for="(item, index) in pageTagsLists" ref="tagsPageOpened" :key="item.name" :name="item.name" @on-close="closePage" @click.native="linkTo(item)" :closable="true" :color="item.children?(item.children[0].name===currentPageName?'blue':'default'):(item.name===currentPageName?'blue':'default')">
                    <Tooltip :content="itemTitle(item)" placement="bottom">
                        {{ itemTitle(item) }}
                    </Tooltip>
                </Tag>
            </transition-group>
        </draggable>
    </div>
</div>
</template>

<script src="./assets/index.js"></script>
