import Vue from 'vue';
import lang from 'element-ui/lib/locale/lang/en';
import locale from 'element-ui/lib/locale';

import {
    Card,
    // Menu,
    // MenuItem,
    Form,
    FormItem,
    Input,
    Select,
    Option,
    // Row,
    // Col,
    Button,
    // Dialog,
    // Divider,
    // DatePicker,
    Notification,
    Icon,
    Table,
    TableColumn,
    // Tabs,
    // TabPane,
    // Pagination,
    // Tooltip,
    Loading,
    Message,
    MessageBox,
    // ButtonGroup,
    // ColorPicker,
    // Collapse,
    // CollapseItem,
    // Empty,
    // Skeleton,
    // SkeletonItem,
    InputNumber,
    Switch,
    // Submenu,
    // MenuItemGroup,
    OptionGroup,
    Radio,
    RadioGroup,
    RadioButton,
    // Checkbox,
    Tag,
    Rate,
    Dialog,
    // Popover,
    // PageHeader,
    // CheckboxGroup,
    // Cascader,
    // Dropdown,
    // DropdownMenu,
    // DropdownItem,
} from 'element-ui';

Vue.use(Card);
// Vue.use(Menu);
// Vue.use(MenuItem);
Vue.use(Form);
Vue.use(FormItem);
Vue.use(Input);
Vue.use(Select);
Vue.use(Option);
// Vue.use(Row);
// Vue.use(Col);
Vue.use(Button);
Vue.use(Dialog);
// Vue.use(Divider);
// Vue.use(DatePicker);
Vue.use(Icon);
// Vue.use(Tabs);
// Vue.use(TabPane);
// Vue.use(Tooltip);
Vue.use(Table);
Vue.use(TableColumn);
// Vue.use(Pagination);
// Vue.use(ButtonGroup);
// Vue.use(ColorPicker);
// Vue.use(Collapse);
// Vue.use(CollapseItem);
// Vue.use(Empty);
// Vue.use(Skeleton);
// Vue.use(SkeletonItem);
Vue.use(InputNumber);
Vue.use(Switch);
// Vue.use(Submenu);
// Vue.use(MenuItemGroup);
Vue.use(OptionGroup);
Vue.use(Radio);
Vue.use(RadioGroup);
Vue.use(RadioButton);
// Vue.use(Checkbox);
// Vue.use(Popover);
Vue.use(Tag);
Vue.use(Rate);

// Vue.use(PageHeader);
// Vue.use(Cascader);
// Vue.use(Dialog);
// Vue.use(Dropdown);
// Vue.use(DropdownMenu);
// Vue.use(DropdownItem);
// Vue.use(CheckboxGroup);
Vue.prototype.$notify = Notification;
Vue.prototype.$message = Message;
Vue.prototype.$msgbox = MessageBox;
Vue.prototype.$confirm = MessageBox.confirm;
Vue.use(Loading.directive);
Vue.prototype.$loading = Loading.service;
locale.use(lang);
export default Vue;