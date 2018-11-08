<style scoped>
.center{
    text-align:center;
}
.color-green{
    width: 100px;
    height: 30px;
    border-radius: 3px;
    float: left;
    position: relative;
    top: 15px;
    left: 20px;
}
.color-red{
    width: 420px;
    margin: 0 auto;
    margin-right: 10px;
}
.marginB
{
    margin-bottom: 24px;
}
    .demo-tabs-style1 > .ivu-tabs-card > .ivu-tabs-content {
        height: 120px;
        margin-top: -16px;
    }

    .demo-tabs-style1 > .ivu-tabs-card > .ivu-tabs-content > .ivu-tabs-tabpane {
        background: #fff;
        padding: 16px;
    }

    .demo-tabs-style1 > .ivu-tabs.ivu-tabs-card > .ivu-tabs-bar .ivu-tabs-tab {
        border-color: transparent;
    }

    .demo-tabs-style1 > .ivu-tabs-card > .ivu-tabs-bar .ivu-tabs-tab-active {
        border-color: #fff;
    }
    .demo-tabs-style2 > .ivu-tabs.ivu-tabs-card > .ivu-tabs-bar .ivu-tabs-tab{
        border-radius: 0;
        background: #fff;
    }
    .demo-tabs-style2 > .ivu-tabs.ivu-tabs-card > .ivu-tabs-bar .ivu-tabs-tab-active{
        border-top: 1px solid #3399ff;
    }
    .demo-tabs-style2 > .ivu-tabs.ivu-tabs-card > .ivu-tabs-bar .ivu-tabs-tab-active:before{
        content: '';
        display: block;
        width: 100%;
        height: 1px;
        background: #3399ff;
        position: absolute;
        top: 0;
        left: 0;
    }
</style>
<template>
    <Row>
        <Col span="24">
            <Card class="center">
                <Alert type="warning" >Booking List
                    <span slot="desc"></span>
                </Alert>
                <!-- table -->
                <p>
                    <Table :columns="columns1" :data="dataGuest"></Table>
                </p>
            </Card>
        </Col>

        <!-- modal -->
        <Modal v-model="viewModal" width="600">
            <p slot="header" style="color:#369;text-align:center">
                <Icon type="edit"></Icon>
                <span> Edit</span>
            </p>
            <div style="">
                <Form ref="formValidate" :model="editObj" :rules="ruleValidate" label-position="top">
                    <FormItem label="Name" prop="name">
                        <Input v-model="editObj.name" placeholder="Enter name" disabled></Input>
                    </FormItem>
                    <FormItem label="Phone" prop="phone">
                        <Input v-model="editObj.phone" placeholder="Enter contact number" disabled></Input>
                    </FormItem>
                    <FormItem label="ID"  prop="nid">
                        <Input v-model="editObj.nid" placeholder="Enter NID/PASSPORT/DRIVING LICENSE" disabled></Input>
                    </FormItem>
                    <FormItem label="E-mail" prop="mail">
                        <Input v-model="editObj.mail" placeholder="Enter e-mail" disabled></Input>
                    </FormItem>
                    <FormItem label="Birth date">
                            <DatePicker type="date" placeholder="Select date" v-model="dob"  @on-change="dateConverter" disabled></DatePicker>
                    </FormItem>
                    <FormItem label="Address" prop="address">
                        <Input v-model="editObj.address" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="Enter full address..." disabled></Input>
                    </FormItem>
                    <FormItem label="Gender" prop="gender">
                        <Input v-model="editObj.gender" disabled>

                        </Input>
                    </FormItem>
                </Form>
            </div>
        </Modal>

        <Modal v-model="editModal" width="600">
            <p slot="header" style="color:#369;text-align:center">
                <Icon type="edit"></Icon>
                <span> Edit</span>
            </p>
            <div style="">
                <Form ref="formValidate" :model="editObj" :rules="ruleValidate" label-position="top">
                    <FormItem label="Name" prop="name">
                        <Input v-model="editObj.name" placeholder="Enter name"></Input>
                    </FormItem>
                    <FormItem label="Phone" prop="phone">
                        <Input v-model="editObj.phone" placeholder="Enter contact number"></Input>
                    </FormItem>
                    <FormItem label="ID"  prop="nid">
                        <Input v-model="editObj.nid" placeholder="Enter NID/PASSPORT/DRIVING LICENSE"></Input>
                    </FormItem>
                    <FormItem label="E-mail" prop="mail">
                        <Input v-model="editObj.mail" placeholder="Enter e-mail"></Input>
                    </FormItem>
                    <FormItem label="Birth date">
                            <DatePicker type="date" placeholder="Select date" v-model="dob"  @on-change="dateConverter" ></DatePicker>
                    </FormItem>
                    <FormItem label="Address" prop="address">
                        <Input v-model="editObj.address" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="Enter full address..."></Input>
                    </FormItem>
                    <FormItem label="Gender" prop="gender">
                        <RadioGroup v-model="editObj.gender">
                            <Radio label="male">Male</Radio>
                            <Radio label="female">Female</Radio>
                        </RadioGroup>
                    </FormItem>
                </Form>
            </div>
            <div slot="footer">
                <Button type="primary" size="large" long :loading="sending" @click="edit">
                    <span v-if="!loading">Update</span>
                    <span v-else>Updating...</span>
                </Button>
            </div>
        </Modal>
        <Modal v-model="deleteModal" width="360">
            <p slot="header" style="color:#f60;text-align:center">
                <Icon type="close"></Icon>
                <span> Delete</span>
            </p>
            <div style="text-align:center">
                Are you sure you want delete

            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loading="sending" @click="remove">
                    <span v-if="!loading">Delete</span>
                    <span v-else>Deleting...</span>
                </Button>
            </div>
        </Modal>
    </Row>

</template>
<script>
    export default {
        data () {
            return {
                viewModal:false,
                editModal:false,
                deleteModal:false,
                sending:false,
                loading:false,
                dob: '',
                UpdateValue:{},
                editObj:{
                    id:'',
                    name: '',
                    mail: '',
                    phone: '',
                    nid: '',
                    address: '',
                    gender: '',
                    guest_id: '',
                    checkin: '',
                    checkout: '',
                    roomNumber: '',
                    bill: '',
                    remarks:'',
                },
                options3: {
                    disabledDate (date) {
                        return date && date.valueOf() < Date.now() - 86400000;
                    }
                },
                options4: {
                    disabledDate (date) {
                        const disabledDay = date.getDate();
                        return disabledDay === 15;
                    }
                },
                 formValidate: {
                    name: '',
                    mail: '',
                    phone: '',
                    nid: '',
                    address: '',
                    gender: '',
                    dob: '',
                    },
                columns1: [
                    {
                        title: 'Name',
                        key: 'name'
                    },
                    {
                        title: 'ID',
                        key: 'nid'
                    },
                    {
                        title: 'Phone',
                        key: 'phone'
                    },
                    {
                        title: 'Address',
                        key: 'address',
                    },
                    {
                        title: 'Action',
                        key: 'action',
                        width: 200,
                        align: 'center',
                        render: (h, params) => {
                            return h('div', [
                                h('Button', {
                                    props: {
                                        type: 'success',
                                        size: 'small'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            this.showView(params.index)
                                        }
                                    }
                                }, 'View'),
                                 h('Button', {
                                    props: {
                                        type: 'primary',
                                        size: 'small'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            this.showEdit(params.index)
                                        }
                                    }
                                }, 'Edit'),
                                h('Button', {
                                    props: {
                                        type: 'error',
                                        size: 'small'
                                    },
                                    on: {
                                        click: () => {
                                            this.showRemove(params.index)
                                        }
                                    }
                                }, 'Delete')
                            ]);
                        }
                    }
                ],
                dataGuest: [



                ],
                checkData:[],
                ruleValidate: {
                    name: [
                        { required: true, message: 'The name cannot be empty', trigger: 'blur' }
                    ],
                    phone: [
                        { required: true, message: 'Please enter phone number', trigger: 'blur' }
                    ],
                    nid: [
                        { required: true, message: 'Please enter phone NID', trigger: 'blur' }
                    ],
                }
            }
        },
        methods: {
            checkDates(key)
            {
                this.checkData=key

            },
            dateConverter(key)
            {
                this.formValidate.dob=key
                this.editObj.dob=key

            },
            handleSubmit (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.addGuest()
                        this.$Message.success('Success!');
                    } else {
                        this.$Message.error('Fail!');
                    }
                })
            },
            handleReset (name) {
                this.$refs[name].resetFields();
            },
            async addGuest(){
                this.loading=true
                try{
                    let {data} =await  axios({
                        method: 'post',
                        url:'/app/guest',
                        data: this.formValidate
                    })
                    this.dataGuest.unshift(data.status)
                    this.s('Great!','Guest has been added successfully!')
                    this.loading=false
                }catch(e){
                    this.loading=false
                    this.e('Oops!','Something went wrong, please try again!')
                }
            },
            showEdit (index) {
                this.editObj.name=this.dataGuest[index].name
                this.editObj.gender=this.dataGuest[index].gender
                this.editObj.mail=this.dataGuest[index].mail
                this.editObj.phone=this.dataGuest[index].phone
                this.editObj.nid=this.dataGuest[index].nid
                this.editObj.address=this.dataGuest[index].address
                this.editObj.dob=this.dataGuest[index].dob
                this.dob=this.dataGuest[index].dob
                this.UpdateValue.indexNumber=index
                this.UpdateValue.id=this.dataGuest[index].id
                this.editModal=true
            },
            showView (index) {
                this.editObj.name=this.dataGuest[index].name
                this.editObj.gender=this.dataGuest[index].gender
                this.editObj.mail=this.dataGuest[index].mail
                this.editObj.phone=this.dataGuest[index].phone
                this.editObj.nid=this.dataGuest[index].nid
                this.editObj.address=this.dataGuest[index].address
                this.editObj.dob=this.dataGuest[index].dob
                this.dob=this.dataGuest[index].dob
                this.UpdateValue.indexNumber=index
                this.UpdateValue.id=this.dataGuest[index].id
                this.viewModal=true
            },
            showRemove (index) {
                this.UpdateValue.id=this.dataGuest[index].id
                this.UpdateValue.indexNumber=index
                this.deleteModal=true
            },
            async edit(){
                this.sending=true
                try{
                    let {data} =await  axios({
                        method: 'put',
                        url:`/app/guest/${this.UpdateValue.id}`,
                        data: this.editObj
                    })
                    this.dataGuest[this.UpdateValue.indexNumber].name=this.editObj.name
                    this.dataGuest[this.UpdateValue.indexNumber].gender=this.editObj.gender
                    this.dataGuest[this.UpdateValue.indexNumber].mail=this.editObj.mail
                    this.dataGuest[this.UpdateValue.indexNumber].phone=this.editObj.phone
                    this.dataGuest[this.UpdateValue.indexNumber].nid=this.editObj.nid
                    this.dataGuest[this.UpdateValue.indexNumber].address=this.editObj.address
                    this.dataGuest[this.UpdateValue.indexNumber].dob=this.editObj.dob
                    this.s('Great!','Guest information has been updated successfully!')

                    this.sending=false
                    this.editModal=false
                }catch(e){
                    this.sending=false
                    this.editModal=false
                    this.e('Oops!','Something went wrong, please try again!')
                }
            },
            async remove(){
                this.sending=true
                try{
                    let {data} =await  axios({
                        method: 'delete',
                        url:`/app/guest/${this.UpdateValue.id}`,
                    })
                    this.dataGuest.splice( this.UpdateValue.indexNumber, 1)
                    this.s('Great!','Group information has been removed successfully!')

                    this.sending=false
                    this.deleteModal=false
                }catch(e){
                    this.sending=false
                    this.deleteModal=false
                    this.e('Oops!','Something went wrong, please try again!')
                }
            }

        },
        async created()
        {
            this.ls();
            try{
                let {data} =await  axios({
                    method: 'get',
                    url:'/app/guest'
                })
                this.dataAdmin=data;

            }catch(e){
                this.e('Oops!','Something went wrong, please try again!')
                this.le();
            }
            try{
                let {data} =await  axios({
                    method: 'get',
                    url:'/app/guest'
                })
                this.dataGuest=data;
                this.lf();

            }catch(e){
                this.e('Oops!','Something went wrong, please try again!')
                this.le();
            }

        }

    }
</script>
