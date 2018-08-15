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
        <Col span="14" offset="1">
            <Card class="center">

                    <Alert type="warning" >Day Shift
                        <span slot="desc"></span>
                    </Alert>
                <p ><Icon type="ios-checkmark-circle" /></p>
                <p >Already Booked </p>
                <p><Button type="primary">View Information</Button></p>
            </Card>
        </Col>
        <Col span="7" offset="1">
            <Card>
                    <Alert  class="center">Add New Guest
                    <span slot="desc"></span>
                    </Alert >
                <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" label-position="top">
                    <FormItem label="Name" prop="name">
                        <Input v-model="formValidate.name" placeholder="Enter name"></Input>
                    </FormItem>
                    <FormItem label="Phone" prop="phone">
                        <Input v-model="formValidate.phone" placeholder="Enter contact number"></Input>
                    </FormItem>
                    <FormItem label="ID"  prop="nid">
                        <Input v-model="formValidate.nid" placeholder="Enter NID/PASSPORT/DRIVING LICENSE"></Input>
                    </FormItem>
                    <FormItem label="E-mail" prop="mail">
                        <Input v-model="formValidate.mail" placeholder="Enter e-mail"></Input>
                    </FormItem>
                    <FormItem label="Birth date">
                            <DatePicker type="date" placeholder="Select date" v-model="formValidate.dob"></DatePicker>
                    </FormItem>
                    <FormItem label="Address" prop="address">
                        <Input v-model="formValidate.address" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="Enter full address..."></Input>
                    </FormItem>
                    <FormItem label="Gender" prop="gender">
                        <RadioGroup v-model="formValidate.gender">
                            <Radio label="male" >Male</Radio>
                            <Radio label="female">Female</Radio>
                        </RadioGroup>
                    </FormItem>
                    <FormItem>
                        <Button type="primary" @click="handleSubmit('formValidate')">Submit</Button>
                        <Button @click="handleReset('formValidate')" style="margin-left: 8px">Reset</Button>
                    </FormItem>
                </Form>
            </Card>
        </Col>
    </Row>
</template>
<script>
    export default {
        data () {
            return {
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

                    this.s('Great!','Sell has been added successfully!')
                    this.loading=false
                }catch(e){
                    this.loading=false
                    this.e('Oops!','Something went wrong, please try again!')
                }
            },
        }
    }
</script>
