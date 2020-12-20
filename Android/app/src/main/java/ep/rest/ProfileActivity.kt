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
            if(etPasswordEdit.text.toString().trim()!=etRepeatPass.text.toString().trim()) tvUpdateError.setText("Gesli se ne ujemata!")
            else {
                val pass = etOldPass.text.toString().trim()
                //val email = etEmailEdit.text.toString().trim()
                val x = arrayOf(0)
                var a = 13
                thread {
                    val test = Test()
                    val res = test.run(pass, id)
                    //Log.i("HTTPresponse", res)
                    a = res
                    x[0]++
                }
                while (x[0] < 1) {
                    Thread.sleep(100)
                }
                if (a != 200) {
                    tvUpdateError.setText("Geslo ni pravilno")
                }
                else{
                    val ime = etIme.text.toString().trim()
                    val priimek = etPriimek.text.toString().trim()
                    val email = etEmailEdit.text.toString().trim()
                    val newPass = etRepeatPass.text.toString().trim()
                    val y = arrayOf(0)
                    var b = 13
                    thread {
                        val test = Test()
                        val res = test.updateUserOK3(user.id,user.aktiven,user.vloga,ime, priimek, email, newPass)
                        b=res
                        y[0]++
                    }
                    while (y[0]<1){
                        Thread.sleep(100)
                    }
                    if (b==200){
                        Log.wtf("HTTP OK 3 update:","Success!")
                        tvUpdateError.setText("Uspešno posodobljeno")
                    }
                    else Log.wtf("HTTP OK 3 update:","FAIL!!!")
                    //BookService.instance.updateUser(user.id,ime, priimek,email,newPass).enqueue(OnLoadCallbacks1(this))
                }
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
            t.printStackTrace()
        }

    }
}

class OnLoadCallbacks1(val profileActivity: ProfileActivity) : Callback<Void> {
    override fun onResponse(call: Call<Void>, response: Response<Void>) {
        if (response.isSuccessful){
            Log.wtf("UPDATE:","SUCCESS!")
        }
        else{
            Log.wtf("UPDATE:","FAIL!")
        }
    }

    override fun onFailure(call: Call<Void>, t: Throwable) {
        t.printStackTrace()
    }

}
