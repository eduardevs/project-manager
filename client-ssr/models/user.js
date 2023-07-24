import { Schema, model, models } from 'mongoose';

const UserSchema = new Schema({
    email: {
        type: String,
        unique: [true, 'Email already exits!'],
        required: [true, 'Email is required']
    },
    username: {
        type: String,
        required: [true, 'Username is required!'],
        match: [/^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/, "Username invalid, it should contain 8-20 alphanumeric letters and be unique!"],
        image: {
            type: String,
        }
    }
})
// ? NOTE:Normally with express, always run server
// const User = model("User", UserSchema);
// TODO: because this is called every single time, so we check.
const User = models.User || model("User", UserSchema);
// and here just a we do with express server.
export default User;




