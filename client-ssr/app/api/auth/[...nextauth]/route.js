import NextAuth from 'next-auth';
import GoogleProvider from 'next-auth/providers/google';

import User from '@models/user';
import { connectToDB } from '@utils/database';

const handler = NextAuth({
  providers: [
    GoogleProvider({
      clientId: process.env.GOOGLE_ID,
      clientSecret: process.env.GOOGLE_CLIENT_SECRET,
    })
  ],
  callbacks: {
    async session({ session }) {
      // store the user id from MongoDB to session
      const sessionUser = await User.findOne({ email: session.user.email });
      session.user.id = sessionUser._id.toString();

      return session;
    },
    async signIn({ account, profile, user, credentials }) {
      try {
        await connectToDB();

        // check if user already exists
        const userExists = await User.findOne({ email: profile.email });

        // if not, create a new document and save user in MongoDB
        if (!userExists) {
          await User.create({
            email: profile.email,
            username: profile.name.replace(" ", "").toLowerCase(),
            image: profile.picture,
          });
        }

        return true
      } catch (error) {
        console.log("Error checking if user exists: ", error.message);
        return false
      }
    },
  }
})

export { handler as GET, handler as POST }
// !BUG : IN THE DATABASE MONGO DB ADD TO USER ATLAS ADMIN to created user





// * Use next function to make auth in nodejs
// - this is a serveless function, which means that is not always running as express server.
// * nextAuth.js doc : https://next-auth.js.org/getting-started/introduction
// import NextAuth from 'next-auth';
// // *  User authentication
// // - calls api google to prepare the call to authentification
// import GoogleProvider from 'next-auth/providers/google';
// // - create oauth keys in cloud google
// // - save variables in .env (GOOGLE_ID, GOOGLE_CLIENT_SECRET)
// // * Create DB instance 
// import { connectToDB } from '@utils/database'
// // - create mongoose cluster in mongoose atlas, and create db in a cluster, with user and password, and copy db connection to use in @utils/database
// //  Create Model for User : (uses mongoose package to manage db)
// import User from "@models/User"
// Check if user already exists

// console.log({
//   clientId: process.env.GOOGLE_ID,
//   clientSecret: process.env.GOOGLE_CLIENT_SECRET
// })

// const handler = NextAuth({
//   providers: [
//     GoogleProvider({
//       clientId: process.env.GOOGLE_ID,
//       clientSecret: process.env.GOOGLE_CLIENT_SECRET,
//     })
//   ],
//   callbacks: {
//     // * to know more about, check DOC nextAuth
//     async session({ session }) {
//       // 2. we want to keep data, once user signs in !
//       const sessionUser = await User.findOne({
//         email: session.user.email
//       })
//       // - we update, to know which user is currently online
//       session.user.id = sessionUser._id.toString();

//       return session;

//     },
//     // 1. Creating signIn function.
//     async signIn({ account, profile, user, credentials }) {

//       // serverless -> lambda function ->dynamodb (we don't have to keep our server running)
//       try {
//         await connectToDB();
//         // console.log(connectToDB);
//         // check if user already exists
//         const userExists = await User.findOne({email: profile.email})
//         // if not, create a new user
//         if(!userExists) {
//           await User.create({
//             email: profile.email,
//             username: profile.name.replace(" ", "").toLowerCase(),
//             image: profile.picture
//           })
//         }
//         return true;
//       } catch (error) {

//         console.log(error);
//         return false;
//       }
//     },
//   }
// })

// export { handler as GET, handler as POST }