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
</style>
<template>
    <Row>
        <Col span="16" >
            <Card class="center">
                <Alert type="warning" >Room List
                    <span slot="desc"></span>
                </Alert>
                <!-- table -->
                <p>
                    <Table :columns="columns1" :data="dataRoom"></Table>
                </p>
            </Card>
        </Col>
        <Col span="1">
            <p> &nbsp;</p>
        </Col>
        <Col span="7">
            <Card>
                    <Alert  class="center">New Room
                    <span slot="desc"></span>
                    </Alert >
                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top">
                    <FormItem label="Name" prop="name">
                        <Input v-model="formValidate.name" placeholder="Enter name"></Input>
                    </FormItem>
                    <FormItem label="Room Number" prop="number">
                        <Input v-model="formValidate.number" placeholder="Enter room number"></Input>
                    </FormItem>
                    <FormItem label="Rent"  >
                        <Input v-model="formValidate.rent" placeholder="Enter rent"></Input>
                    </FormItem>
                    <FormItem label="Capactiy" >
                        <Input v-model="formValidate.capacity" placeholder="Enter guests capacity"></Input>
                    </FormItem>
                    <FormItem label="Detailed information">
                        <Input v-model="formValidate.remarks" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="Enter information..."></Input>
                    </FormItem>
                    <FormItem>
                        <Button type="primary" @click="add">Add</Button>
                        <Button @click="handleReset('formValidate')" style="margin-left: 8px">Reset</Button>
                    </FormItem>
                </Form>
            </Card>
        </Col>
        <!-- modal -->
        <Modal v-model="viewModal" width="600">
            <p slot="header" style="color:#369;text-align:center">
                <Icon type="edit"></Icon>
                <span> Edit</span>
            </p>
            <div style="">
                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top">
                    <FormItem label="Name" prop="name">
                        <Input v-model="editObj.name" placeholder="Enter name" disabled></Input>
                    </FormItem>
                    <FormItem label="Room Number" prop="number">
                        <Input v-model="editObj.number" placeholder="Enter room number" disabled></Input>
                    </FormItem>
                    <FormItem label="Rent"  >
                        <Input v-model="editObj.rent" placeholder="Enter rent" disabled></Input>
                    </FormItem>
                    <FormItem label="Capactiy" >
                        <Input v-model="editObj.capacity" placeholder="Enter guests capacity" disabled></Input>
                    </FormItem>
                    <FormItem label="Detailed information">
                        <Input v-model="editObj.remarks" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="Enter information..." disabled></Input>
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
                <Form ref="editObj" :model="editObj" :rules="ruleValidate" label-position="top">
                    <FormItem label="Name" prop="name">
                        <Input v-model="editObj.name" placeholder="Enter name"></Input>
                    </FormItem>
                    <FormItem label="Room Number" prop="number">
                        <Input v-model="editObj.number" placeholder="Enter room number"></Input>
                    </FormItem>
                    <FormItem label="Rent"  >
                        <Input v-model="editObj.rent" placeholder="Enter rent"></Input>
                    </FormItem>
                    <FormItem label="Capactiy" >
                        <Input v-model="editObj.capacity" placeholder="Enter guests capacity"></Input>
                    </FormItem>
                    <FormItem label="Detailed information">
                        <Input v-model="editObj.remarks" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="Enter information..."></Input>
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
                    number: '',
                    rent: '',
                    capacity: '',
                    remarks: '',
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
                    number: '',
                    rent: '',
                    capacity: '',
                    remarks: '',
                    },
                columns1: [
                    {
                        title: 'Name',
                        key: 'name'
                    },
                    {
                        title: 'Number',
                        key: 'number'
                    },
                    {
                        title: 'Rent',
                        key: 'rent'
                    },
                    {
                        title: 'Capacity',
                        key: 'capacity'
                    },
                    {
                        title: 'Info',
                        key: 'remarks',
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
                dataRoom: [



                ],
                ruleValidate: {
                    name: [
                        { required: true, message: 'The name cannot be empty', trigger: 'blur' }
                    ],
                    number: [
                        { required: true, message: 'Please enter room number', trigger: 'blur' }
                    ],

                }
            }
        },
        methods: {
            handleSubmit (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.add()
                        this.$Message.success('Success!');
                    } else {
                        this.$Message.error('Fail!');
                    }
                })
            },
            handleReset (name) {
                this.$refs[name].resetFields();
            },
            async add(){
                this.loading=true
                try{
                    let {data} =await  axios({
                        method: 'post',
                        url:'/app/room',
                        data: this.formValidate
                    })
                    this.dataRoom.unshift(data.status)
                    this.s('Great!','Room has been added successfully!')
                    this.loading=false
                }catch(e){
                    this.loading=false
                    this.e('Oops!','Something went wrong, please try again!')
                }
            },
            showEdit (index) {
                this.editObj.name=this.dataRoom[index].name
                this.editObj.number=this.dataRoom[index].number
                this.editObj.rent=this.dataRoom[index].rent
                this.editObj.capacity=this.dataRoom[index].capacity
                this.editObj.remarks=this.dataRoom[index].remarks
                this.UpdateValue.indexNumber=index
                this.UpdateValue.id=this.dataRoom[index].id
                this.editModal=true
            },
            showView (index) {
                this.editObj.name=this.dataRoom[index].name
                this.editObj.number=this.dataRoom[index].number
                this.editObj.rent=this.dataRoom[index].rent
                this.editObj.capacity=this.dataRoom[index].capacity
                this.editObj.remarks=this.dataRoom[index].remarks
                this.UpdateValue.indexNumber=index
                this.UpdateValue.id=this.dataRoom[index].id
                this.viewModal=true
            },
            showRemove (index) {
                this.UpdateValue.id=this.dataRoom[index].id
                this.UpdateValue.indexNumber=index
                this.deleteModal=true
            },
            async edit(){
                this.sending=true
                try{
                    let {data} =await  axios({
                        method: 'put',
                        url:`/app/room/${this.UpdateValue.id}`,
                        data: this.editObj
                    })
                    this.dataRoom[this.UpdateValue.indexNumber].name=this.editObj.name
                    this.dataRoom[this.UpdateValue.indexNumber].number=this.editObj.number
                    this.dataRoom[this.UpdateValue.indexNumber].rent=this.editObj.rent
                    this.dataRoom[this.UpdateValue.indexNumber].capacity=this.editObj.capacity
                    this.dataRoom[this.UpdateValue.indexNumber].remarks=this.editObj.remarks
                    this.s('Great!','Room information has been updated successfully!')

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
                        url:`/app/room/${this.UpdateValue.id}`,
                    })
                    this.dataRoom.splice( this.UpdateValue.indexNumber, 1)
                    this.s('Great!','Room information has been removed successfully!')

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
                    url:'/app/room'
                })
                this.dataRoom=data;
                this.lf();

            }catch(e){
                this.e('Oops!','Something went wrong, please try again!')
                this.le();
            }

        }

    }
</script>
