import{bK as u,o as r,y as d,w as i,a,u as s,Z as c,c as p,b6 as f,z as _,b as t,M as w,as as b,bD as y}from"./app-DnY1AJ9R.js";import{_ as g}from"./GuestLayout-46LnHPk3.js";import{_ as x,a as k,b as V}from"./TextInput-B_sIJVm5.js";import{P as h}from"./PrimaryButton-Bl-i-fif.js";import"./ApplicationLogo-BkTzSQQJ.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const v=t("div",{class:"mb-4 text-sm text-gray-600"}," Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one. ",-1),B={key:0,class:"mb-4 font-medium text-sm text-green-600"},N={class:"flex items-center justify-end mt-4"},D={__name:"ForgotPassword",props:{status:{type:String}},setup(o){const e=u({email:""}),m=()=>{e.post(route("password.email"))};return(P,l)=>(r(),d(g,null,{default:i(()=>[a(s(c),{title:"Forgot Password"}),v,o.status?(r(),p("div",B,f(o.status),1)):_("",!0),t("form",{onSubmit:y(m,["prevent"])},[t("div",null,[a(x,{for:"email",value:"Email"}),a(k,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(e).email,"onUpdate:modelValue":l[0]||(l[0]=n=>s(e).email=n),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),a(V,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),t("div",N,[a(h,{class:b({"opacity-25":s(e).processing}),disabled:s(e).processing},{default:i(()=>[w(" Email Password Reset Link ")]),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{D as default};
