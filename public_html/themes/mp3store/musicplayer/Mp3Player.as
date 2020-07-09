package {
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.media.Sound;
	import flash.media.SoundChannel;
	import flash.media.SoundTransform;
	import flash.net.URLRequest;
	import flash.utils.clearInterval;
	import flash.utils.setInterval;		
	
	public class Mp3Player extends EventDispatcher {

		static public const EVENT_TIME_CHANGE:String = 'Mp3Player.TimeChange';
		static public const EVENT_VOLUME_CHANGE:String = 'Mp3Player.VolumeChange';
		static public const EVENT_PAN_CHANGE:String = 'Mp3Player.PanningChange';
		static public const EVENT_PAUSE:String = 'Mp3Player.Pause';
		static public const EVENT_UNPAUSE:String = 'Mp3Player.Unpause';
		static public const EVENT_PLAY:String = 'Mp3Player.Play';
		
		//
		public var playing:Boolean;
		public var playlist:Array;
		public var currentUrl:String;
		public var playlistIndex:int = -1;
		public var songLengthEstimated:Number;
		public var songLengthActual:Number;
		
		//
		public var sound:Sound;
		public var soundChannel:SoundChannel;
		public var soundTrans:SoundTransform;
		public var progressInt:Number;
		
				
		public function play( url:String ):void
		{
			clearInterval(progressInt);
			if ( sound )
			{
				soundChannel.stop();
			}
			
			currentUrl = url;
			sound = new Sound();
			sound.addEventListener(Event.COMPLETE, onLoadSong);
			sound.addEventListener(Event.ID3, onId3Info);

			sound.load(new URLRequest(currentUrl));

			soundChannel = sound.play();
			
			if ( soundTrans ) 
			{
				soundChannel.soundTransform = soundTrans;
			} else
			{
				soundTrans = soundChannel.soundTransform;
			}
			
			soundChannel.addEventListener(Event.COMPLETE, onSongEnd);
			playing = true;
			clearInterval(progressInt);
			progressInt = setInterval(updateProgress, 30);
			dispatchEvent(new Event(EVENT_PLAY));
		}
		
		
		
		
		
		
		public function pause():void 
		{
			if ( soundChannel )
			{
				soundChannel.stop();
				dispatchEvent(new Event(EVENT_PAUSE));
				playing = false;
			}
		}
		
		public function get bytesTotal():Number 
		{
			return sound.bytesTotal;
		}
				
		
		public function unpause():void 
		{
			if ( playing ) return;
			if ( soundChannel.position < sound.length ) 
			{
				soundChannel = sound.play(soundChannel.position);
				soundChannel.soundTransform = soundTrans;
			} 
			else
			{
				soundChannel = sound.play();
			}
			dispatchEvent(new Event(EVENT_UNPAUSE));
			playing = true;
		}
		
		public function seek( percent:Number):void 
		{				
			soundChannel.stop();
			soundChannel = sound.play(sound.length * percent);
			soundChannel.soundTransform = soundTrans;
		}
		
		public function prev():void 
		{
			playlistIndex--;
			if ( playlistIndex < 0 ) playlistIndex = playlist.length - 1;
			play(playlist[playlistIndex]);
		}
		
		public function next():void 
		{
			playlistIndex++;
			if ( playlistIndex == playlist.length ) playlistIndex = 0;
			play(playlist[playlistIndex]);
		}
		
		public function get volume():Number 
		{
			if (!soundTrans) return 0;
			return soundTrans.volume;
		}
		
		public function set volume( n:Number ):void 
		{
			if ( !soundTrans ) return;
			soundTrans.volume = n;
			soundChannel.soundTransform = soundTrans;
			dispatchEvent(new Event(EVENT_VOLUME_CHANGE));
		}
		
		public function get pan():Number
		{
			if (!soundTrans) return 0;
			return soundTrans.pan;
		}
		
		public function set pan( n:Number ):void 
		{
			if ( !soundTrans ) return;
			soundTrans.pan = n;
			soundChannel.soundTransform = soundTrans;
			dispatchEvent(new Event(EVENT_PAN_CHANGE));
		}
		
		public function get length():Number 
		{
			return sound.length;
		}
		
		public function get time():Number
		{
			return soundChannel.position;
		}
		
		public function get timePretty():String 
		{
			var secs:Number = soundChannel.position / 1000;
			var mins:Number = Math.floor(secs / 60);
			secs = Math.floor(secs % 60);
			return mins + ":" + (secs < 10 ? "0" : "") + secs;
		}
		
		public function get lengthPretty():String
		{
			var secs:Number = sound.length / 1000;
			var mins:Number = Math.floor(secs / 60);
			secs = Math.floor(secs % 60);								
			return mins + ":" + (secs < 10 ? "0" : "") + secs;				
		}
		
		// This first attempts to estimate the length of the file while it's loading and then corrects it to the actual length
		// once the file has finished loading. Accurate to within a couple of seconds even on huge mp3s.
		public function get realLengthPretty():String
		{	
			var secs:Number;
			var mins:Number;
			
			if (sound.bytesTotal != sound.bytesLoaded)
			{
				var songLen:Number = sound.length / sound.bytesLoaded * sound.bytesTotal;						
				secs = Math.round(songLen / 1000);
				mins = Math.floor(secs / 60);
				secs = Math.floor(secs % 60);	
			}
			else if(sound.bytesTotal == sound.bytesLoaded)
			{
				secs = sound.length / 1000;
				mins = Math.floor(secs / 60);
				secs = Math.floor(secs % 60);	
			}				
				return mins + ":" + (secs < 10 ? "0" : "") + secs;			
		}
		
				
		public function get progressPercent():Number
		{
			if ( !sound.length ) return 0;
			
			var myActualPercent:Number;
			
			if (sound.bytesTotal != sound.bytesLoaded)
			{
				myActualPercent = sound.length / sound.bytesLoaded * sound.bytesTotal;	
			}
			else if (sound.bytesTotal != sound.bytesLoaded)
			{
				myActualPercent = sound.length;
			}
						
			return soundChannel.position / myActualPercent;
			//return soundChannel.position / sound.byesTotal;
			
		}

		
		// Called when progress bar is clicked to set a new position
		public function get timePercent():Number
		{
			if ( !sound.length ) return 0;
			return soundChannel.position / sound.length;
			//return soundChannel.position / sound.byesTotal;
		}
		
		
		public function get loadPercent():Number
		{
			if ( !sound.length ) return 0;
			var songLen:Number = sound.length / sound.bytesLoaded * sound.bytesTotal;
			return sound.bytesLoaded / sound.bytesTotal;			
		}
		
		protected function onLoadSong( e:Event ):void 
		{
		}
		
		protected function onSongEnd( e:Event ):void
		{
			if ( playlist )
			{
				next();
			}
		}
		
		protected function onId3Info( e:Event ):void 
		{
			dispatchEvent(new Event(Event.ID3, e.target.id3));
		}
		
		protected function updateProgress():void 
		{
			dispatchEvent(new Event(EVENT_TIME_CHANGE));
			if ( timePercent >= .99 ) 
			{
				onSongEnd(new Event(Event.COMPLETE));
				clearInterval(progressInt);
			}
		}
	}
}
