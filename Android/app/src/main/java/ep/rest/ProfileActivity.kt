package ep.rest

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import kotlinx.android.synthetic.main.activity_book_detail.*
import kotlinx.android.synthetic.main.activity_profile.*
import kotlinx.android.synthetic.main.content_book_detail.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.IOException
import kotlin.concurrent.thread


class ProfileActivity : AppCompatActivity() {
    private var user: User = User()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_profile)
        val id = intent.getStringExtra("email")

        if (id != "" && id != null) {
            BookService.instance.getUserByEmail(id).enqueue(ProfileActivity.OnLoadCallbacks(this))
        }

        btnPreklici.setOnClickListener {
            val intent = Intent(this,MainActivity::class.java)
            intent.putExtra("email",id)
            startActivity(intent)
        }
        btnPosodobi.setOnClickListener {
            if(etPasswordEdit!=etRepeatPass) tvUpdateError.setText("Gesli se ne ujemata!")
            val pass = etOldPass.text.toString().trim()
            //val email = etEmailEdit.text.toString().trim()
            val x = arrayOf(0)
            var a=13
            thread {
                val test=Test()
                val res=test.run(pass, id)
                //Log.i("HTTPresponse", res)
                a=res
                x[0]++
            }
        }

    }

    class OnLoadCallbacks(val profileActivity: ProfileActivity) : Callback<Array<User>> {
        private val tag = this::class.java.canonicalName
        override fun onResponse(call: Call<Array<User>>, response: Response<Array<User>>) {
            profileActivity.user = response.body()?.component1() ?: User()
            if (response.isSuccessful) {
               // activity.tvBookDetail.text = activity.book.opis
               // activity.toolbarLayout.title = activity.book.ime
                profileActivity.etIme.setText(profileActivity.user.ime)
                profileActivity.etPriimek.setText(profileActivity.user.priimek)
                profileActivity.etEmailEdit.setText(profileActivity.user.email)
            } else {
                val errorMessage = try {
                    "An error occurred: ${response.errorBody()?.string()}"
                } catch (e: IOException) {
                    "An error occurred: error while decoding the error message."
                }

                Log.e(tag, errorMessage)
                //activity.tvBookDetail.text = errorMessage
            }
        }

        override fun onFailure(call: Call<Array<User>>, t: Throwable) {
            TODO("Not yet implemented")
        }

    }
}