module.exports = {
    logStart(){
        console.log('Bot has been started...')
    },

//hadib msg.chat.id yozmasli uchun shu functionni chaqirb qoysa boldi
    getChatId(msg){
        return msg.chat.id
    },

    getMessageId(msg){
        return msg.message_id
    },

    debug(obj={}){
        return JSON.stringify(obj,null,4);
    }

}